<?php

namespace Source\App;

use Source\Core\Controller;
use Source\Core\Session;
use Source\Core\View;
use Source\Models\Auth;
use Source\Models\CafeApp\AppCategory;
use Source\Models\CafeApp\AppInvoice;
use Source\Models\CafeApp\AppOrder;
use Source\Models\CafeApp\AppPlan;
use Source\Models\CafeApp\AppSubscription;
use Source\Models\CafeApp\AppWallet;
use Source\Models\Post;
use Source\Models\Report\Access;
use Source\Models\Report\Online;
use Source\Models\User;
use Source\Support\Email;
use Source\Support\QRC;
use Source\Support\PDF;
use Source\Support\Thumb;
use Source\Support\Upload;
use Source\Support\Pager;
use Source\Models\Reservation;
use Source\Models\Status;
use Source\Models\Payment;
use Source\Models\Works;
use Source\Models\Customer;
use Source\Models\Maintenance;
use Source\Models\Equipment;
use Source\Models\SupplierType;
use Source\Models\Stage;
use Source\Models\Task;
use Source\Models\StageCategory;
use Source\Models\EquipmentCategory;
use Source\Models\EquipmentWorker;
use Source\Models\EquipmentFile;
use Source\Models\EquipmentQrcode;
use Source\Models\ServiceCategory;
use Source\Models\OccupationCategory;
use Source\Models\CollaboratorCategory;
use Source\Models\Supplier;
use Source\Models\Employee;
use Source\Models\ProjectFile;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Class Work
 * @package Source\Work
 */
class Work extends Controller
{
    /** @var User */
    private $user;
	private $project;

    /**
     * Work constructor.
     */
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../themes/" . CONF_VIEW_WORK . "/");

        if (!$this->user = Auth::user()) {
            $this->message->warning("Efetue login para acessar o APP.")->flash();
            redirect("/entrar");
        }

        (new Access())->report();
        (new Online())->report();

		(new AppWallet())->start($this->user);
        (new AppInvoice())->fixed($this->user, 3);

        //UNCONFIRMED EMAIL
        if ($this->user->status != "confirmed") {
            $session = new Session();
            if (!$session->has("appconfirmed")) {
                $this->message->info("IMPORTANTE: Acesse seu e-mail para confirmar seu cadastro e ativar todos os recursos.")->flash();
                $session->set("appconfirmed", true);
                (new Auth())->register($this->user);
            }
        }
    }

	 /**
     * @param array|null $data
     */
    public function dash(?array $data): void
    {
        if (!empty($data["wallet"])) {
            $session = new Session();

            if ($data["wallet"] == "all") {
                $session->unset("walletfilter");
                echo json_encode(["filter" => true]);
                return;
            }
			
			if ($data["wallet"] == "anual") {
                $session->set("walletfilter", "anual");
                echo json_encode(["filter" => true]);
                return;
            }
			
			if ($data["wallet"] == "mensal") {
                $session->set("walletfilter", "mensal");
                echo json_encode(["filter" => true]);
                return;
            }
		
            $wallet = filter_var($data["wallet"], FILTER_VALIDATE_INT);
			
            $getWallet = (new AppWallet())->find("application_id = :application_id AND id = :id",
                "application_id={$this->user->application_id}&id={$wallet}")->count();

            if ($getWallet) {
                $session->set("walletfilter", $wallet);
            }

            echo json_encode(["filter" => true]);
            return;
        }

        //CHART UPDATE
        $chartData = (new AppInvoice())->chartData($this->user);
        $categories = str_replace("'", "", explode(",", $chartData->categories));
        $json["chart"] = [
            "categories" => $categories,
            "income" => array_map("abs", explode(",", $chartData->income)),
            "expense" => array_map("abs", explode(",", $chartData->expense))
        ];

        //WALLET
        $wallet = (new AppInvoice())->balance2($this->user);
        $wallet->wallet = str_price($wallet->wallet);
        $wallet->status = ($wallet->balance == "positive" ? "gradient-green" : "gradient-red");
        $wallet->income = str_price($wallet->income);
        $wallet->expense = str_price($wallet->expense);
		$wallet->incomeunpaid = str_price($wallet->incomeunpaid);
        $wallet->expenseunpaid = str_price($wallet->expenseunpaid);
		$wallet->projectcost = str_price($wallet->projectcost);
		
        $json["wallet"] = $wallet;
        echo json_encode($json);
    }

    /**
     * APP HOME
     */
    public function home(): void
    {
       $head = $this->seo->render(
            "Olá {$this->user->first_name}. Vamos controlar? - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );
		
	
        //CHART
        $chartData = (new AppInvoice())->chartData($this->user);
        //END CHART
		  
		//Stages
		$stages = (new Stage())->find("application_id = :application","application={$this->user->application_id}")->order("stage_name")->fetch(true);
		
		//Tasks
		$tasks = (new Task())->find("application_id = :application","application={$this->user->application_id}")->order("task_name")->fetch(true);

		//Works
		$works = (new Works())->find("application_id = :application","application={$this->user->application_id}")->order("name")->fetch(true);
		
		
		

        //INCOME && EXPENSE
        $whereWallet = "";
        if ((new Session())->has("walletfilter")) {
			
			if ((new Session())->walletfilter == "anual") {	
				$whereWallet = "";
				
			} else if ((new Session())->walletfilter == "mensal") {		
				$whereWallet = "";
			}	
			else {
				$whereWallet = "AND wallet_id = " . (new Session())->walletfilter;
	
			}
			
        }

        $income = (new AppInvoice())
            ->find("application_id = :application_id AND type = 'income' AND status = 'unpaid' AND date(due_at) <= date(now() + INTERVAL 1 MONTH) {$whereWallet}",
                "application_id={$this->user->application_id}")
            ->order("due_at")
            ->fetch(true);

        $expense = (new AppInvoice())
            ->find("application_id = :application_id AND type = 'expense' AND status = 'unpaid' AND date(due_at) <= date(now() + INTERVAL 1 MONTH) {$whereWallet}",
                "application_id={$this->user->application_id}")
            ->order("due_at")
            ->fetch(true);
        //END INCOME && EXPENSE

        //WALLET
        $wallet = (new AppInvoice())->balance2($this->user);
        //END WALLET

        //POSTS
        $posts = (new Post())->findPost()->limit(3)->order("post_at DESC")->fetch(true);
        //END POSTS

        echo $this->view->render("home", [
            "head" => $head,
            "chart" => $chartData,
            "income" => $income,
            "expense" => $expense,
            "wallet" => $wallet,
            "posts" => $posts,
			"stages"  => $stages,
			"tasks"  => $tasks,
			"works"  => $works
			
        ]);
	    
    }

    /**
     * @param array $data
     * @throws \Exception
     */
    public function filter(array $data): void
    {
        $status = (!empty($data["status"]) ? $data["status"] : "all");
        $category = (!empty($data["category"]) ? $data["category"] : "all");
        $date = (!empty($data["date"]) ? $data["date"] : date("m/Y"));

        list($m, $y) = explode("/", $date);
        $m = ($m >= 1 && $m <= 12 ? $m : date("m"));
        $y = ($y <= date("Y", strtotime("+10year")) ? $y : date("Y", strtotime("+10year")));

        $start = new \DateTime(date("Y-m-t"));
        $end = new \DateTime(date("Y-m-t", strtotime("{$y}-{$m}+1month")));
        $diff = $start->diff($end);

        if (!$diff->invert) {
            $afterMonths = (floor($diff->days / 30));
            (new AppInvoice())->fixed($this->user, $afterMonths);
        }
		
		$redirect = ($data["filter"] == "income" ? "receber" : "pagar");
        $json["redirect"] = url("/work/{$redirect}/{$status}/{$category}/{$m}-{$y}");
        echo json_encode($json);
	 
    }

    /**
     * @param array|null $data
     */
    public function income(?array $data): void
    {
        $head = $this->seo->render(
            "Minhas Receitas",
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        $categories = (new AppCategory())
            ->find("application_id = :application AND type = :t", "t=income&application={$this->user->application_id}", "id, name")
            ->order("order_by, name")
            ->fetch("true");

        echo $this->view->render("invoices", [
            "user" => $this->user,
            "head" => $head,
            "type" => "income",
            "categories" => $categories,
            "invoices" => (new AppInvoice())->filter($this->user, "income", ($data ?? null)),
            "filter" => (object)[
                "status" => ($data["status"] ?? null),
                "category" => ($data["category"] ?? null),
				"date" => (!empty($data["date"]) ? str_replace("-", "/", $data["date"]) : null) || ($data["date"] ?? null),
            ]
        ]);
    }

    /**
     * @param array|null $data
     */
    public function expense(?array $data): void
    {
        $head = $this->seo->render(
            "Minhas despesas - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        $categories = (new AppCategory())
            ->find("application_id = :application AND type = :t", "t=expense&application={$this->user->application_id}", "id, name")
            ->order("order_by, name")
            ->fetch("true");

        echo $this->view->render("invoices", [
            "user" => $this->user,
            "head" => $head,
            "type" => "expense",
            "categories" => $categories,
            "invoices" => (new AppInvoice())->filter($this->user, "expense", ($data ?? null)),
            "filter" => (object)[
                "status" => ($data["status"] ?? null),
                "category" => ($data["category"] ?? null),
                "date" => (!empty($data["date"]) ? str_replace("-", "/", $data["date"]) : null)
            ]
        ]);
    }
	
	/**
     * @param array|null $data
     */
    public function invoices(?array $data): void
    {
        $head = $this->seo->render(
            "Minhas despesas - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );
		
		$wallet = (new AppWallet())->findById($data["id"]);
	
		$categories = (new AppCategory())
            ->find("application_id = :application", "application={$this->user->application_id}", "id, name")
            ->order("order_by, name")
            ->fetch("true");
					
		if (empty($data["type"])) {
			$type = "all";			
		} else {
			$type = $data["type"];
		}	
		
		if (empty($data["category"])) {
			$category = "all";			
		} else {
			$category = $data["category"];
		}	

		if (empty($data["dateinitial"])) {
			$dateinitial = "all";		
		} else {
			$dateinitial = $data["dateinitial"];
		}	

		if (empty($data["datefinal"])) {
			$datefinal = "all";	
		} else {
			$datefinal = $data["datefinal"];
		}	
		
		if (!empty($data["id"])){
			$pager = new Pager(url("/work/faturas/{$data["id"]}/{$type}/{$category}/{$dateinitial}/{$datefinal}/"));
			$count = (new AppInvoice())->filterInvoicesCount($this->user,($data ?? null));
			
		} elseif (empty($data["id"])) {		
			$pager = new Pager(url("/work/faturas/{$type}/{$category}/{$dateinitial}/{$datefinal}/"));
			$count = (new AppInvoice())->filterInvoicesCount($this->user,($data ?? null));	
		}
	
		$pager->pager($count->count(),25,(!empty($data["page"]) ? $data["page"] : 1));

        echo $this->view->render("invoices2", [
            "user" => $this->user,
            "head" => $head,
            "categories" => $categories,
			"wallet" => $wallet,
			"paginator" => $pager->render(),
            "invoices" => (new AppInvoice())->filterInvoices($this->user,($data ?? null),$pager->limit(),$pager->offset()),
            "filter" => (object)[
				"type" => ($data["type"] ?? null),
                "category" => ($data["category"] ?? null),
                "dateinitial" => ($data["dateinitial"] ??  null),
				"datefinal" => ($data["datefinal"] ??  null),
				"id" => ($data["id"] ??  null)
            ]
		
        ]);
    }
	
	/**
     * APP Modal modal Import Invoices
     */
    public function modalImportInvoices(array $data): void
    {	
	
		if ($_FILES["cover"]["name"] != '') {
			$allowed_extension = array('xls', 'csv', 'xlsx');
			$file_array = explode(".", $_FILES["cover"]["name"]);
			$file_extension = end($file_array);
			
			if (in_array($file_extension, $allowed_extension)) {
				$inputFileName = time() . '.' . $file_extension;
				move_uploaded_file($_FILES['cover']['tmp_name'], $inputFileName);
			
				$inputFileType = IOFactory::identify($inputFileName);
				
				$reader = IOFactory::createReader($inputFileType);
				$spreadsheet = $reader->load($inputFileName);
				
				unlink($inputFileName);
				
				$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
				$description = $spreadsheet->getActiveSheet()->getCell('A1')->getFormattedValue();
				$category = $spreadsheet->getActiveSheet()->getCell('B1')->getFormattedValue();
				$value = $spreadsheet->getActiveSheet()->getCell('C1')->getFormattedValue();
				$type = $spreadsheet->getActiveSheet()->getCell('D1')->getFormattedValue();
				$due_at = $spreadsheet->getActiveSheet()->getCell('E1')->getFormattedValue();
				$status = $spreadsheet->getActiveSheet()->getCell('F1')->getFormattedValue();

				if (($description == "DESCRIÇÃO") && ($category == "CATEGORIA")  && ($value == "VALOR") && ($type == "TIPO") && ($due_at == "DATA DE PAGAMENTO") && ($status == "STATUS")) {
	
					array_shift($sheetData);
					foreach($sheetData as $columnspreadsheet){
											
						$spreadsheetdata  = [
							'description'	=>	$columnspreadsheet["A"],
							'category'		=>	$columnspreadsheet["B"],
							'value'		    =>	$columnspreadsheet["C"],
							'type'			=>	$columnspreadsheet["D"],
							'due_at'		=>	$columnspreadsheet["E"],	
							'status'		=>	$columnspreadsheet["F"],
						];
						
						if ($spreadsheetdata["type"] == "RECEITA") {
							$type = "income";
			
						} else if ($spreadsheetdata["type"] == "DESPESA") {
							$type = "expense";
						}
						
						$categoryfind = (new AppCategory())->findByName($spreadsheetdata["category"], $this->user->application_id);
						
						if (!$categoryfind) {
							$categoryCreate = (new AppCategory())->bootstrap(
								$this->user->id,
								$this->user->application_id,
								$type,
								$spreadsheetdata["category"],
							)->save();
		
						}
					
						$wallet = $data['id'];
						$invoice = new AppInvoice();
						
						if (!$invoice->importExcel($this->user, $spreadsheetdata, $wallet)) {
							$json["message"] = $invoice->message()->render();
							echo json_encode($json);
							return;
							
						}

					}		
				}	
				$json["message"] = $this->message->success("Faturas Importadas com sucesso!")->render();
				echo json_encode($json);
				return;
					
			} else {	
				$json["message"] = $this->message->error("Somente Arquivos nos Formtatos .xls .csv or .xlsx são aceitos")->render();
				echo json_encode($json);
				return;
				
			}
		} else {
			$json["message"] = $this->message->error("Por Favor Escolha um Arquivo")->render();
			echo json_encode($json);
			return;
		}
		

    }
	
	
	
	/**
     * @param array $data
     * @throws \Exception
     */
    public function invoiceFilter(array $data): void
    {
		
		if ((empty($data["dateinitial"]) or $data["dateinitial"] == "all") && (!empty($data["datefinal"]) && $data["datefinal"] != "all")) {	
			$json["message"] = $this->message->error("Escolha Uma Data inicial")->render();
            echo json_encode($json);
            return;	
						
		} elseif ((!empty($data["dateinitial"]) && $data["dateinitial"] != "all") && (empty($data["datefinal"]) or $data["datefinal"] == "all")) {
			$json["message"] = $this->message->error("Escolha Uma Data Final")->render();
            echo json_encode($json);
            return;
		}
		
		if (!empty($data["id"])) {
			$type = (!empty($data["type"]) ? $data["type"] : "all");
			$category = (!empty($data["category"]) ? $data["category"] : "all");
			$dateinitial = (!empty($data["dateinitial"]) ? $data["dateinitial"] : "all");
			$datefinal = (!empty($data["datefinal"]) ? $data["datefinal"] : "all");
			$redirect = "faturas/{$data["id"]}";
			$json["redirect"] = url("/work/{$redirect}/{$type}/{$category}/{$dateinitial}/{$datefinal}");
			echo json_encode($json);
			
		} else if (empty($data["id"])) {
			$type = (!empty($data["type"]) ? $data["type"] : "all");
			$category = (!empty($data["category"]) ? $data["category"] : "all");
			$dateinitial = (!empty($data["dateinitial"]) ? $data["dateinitial"] : "all");
			$datefinal = (!empty($data["datefinal"]) ? $data["datefinal"] : "all");
			$redirect = "faturas";
			$json["redirect"] = url("/work/{$redirect}/{$type}/{$category}/{$dateinitial}/{$datefinal}");
			echo json_encode($json);		
		}
    }
	
	/**
     * @param array|null $data
     */
    public function invoicesImport(?array $data): void
    {
     
		if ($_FILES["cover"]["name"] != '') {
			$allowed_extension = array('xls', 'csv', 'xlsx');
			$file_array = explode(".", $_FILES["cover"]["name"]);
			$file_extension = end($file_array);
			
			if (in_array($file_extension, $allowed_extension)) {
				$file_name = time() . '.' . $file_extension;
				move_uploaded_file($_FILES['cover']['tmp_name'], $file_name);
				$file_type = IOFactory::identify($file_name);
				$reader = IOFactory::createReader($file_type);

				$spreadsheet = $reader->load($file_name);

				unlink($file_name);

				$planilha = $spreadsheet->getActiveSheet()->toArray();

				foreach ($planilha as $row) {
					$insert_data  = [
						'description'		=>	$row[0],
						'type'		        =>	$row[1],
						'category'		    =>	$row[2],
						'due_at'			=>	$row[3],
						'value'		        =>	$row[4],	
						'status'		    =>	$row[5]
					];
					
					
					$invoice = new AppInvoice();
					if (!$invoice->importExcel($this->user, $insert_data, $data["wallet"])) {
						$json["message"] = $invoice->message()->render();
						echo json_encode($json);
						return;
					}
				}
				
				$json["message"] = $this->message->error("Faturas Importadas com Sucesso")->render();
				echo json_encode($json);
				return;	
				
			} else {
				$json["message"] = $this->message->error("Apenas arquivos no formato .xls .csv or .xlsx são permitidos")->render();
				echo json_encode($json);
				return;	
			}
		} else {
			$json["message"] = $this->message->error("Por favor escolha um arquivo")->render();
			echo json_encode($json);
			return;	
		}

		$head = $this->seo->render(
            "Importar Faturas",
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );
		
        echo $this->view->render("invoices-import", [
            "user" => $this->user,
            "head" => $head,
            "categories" => $categories,
			"paginator" => $pager->render(),
            "invoices" => (new AppInvoice())->filterInvoices($this->user,($data ?? null),$pager->limit(),$pager->offset()),
            "filter" => (object)[
				"type" => ($data["type"] ?? null),
                "category" => ($data["category"] ?? null),
                "dateinitial" => ($data["dateinitial"] ??  null),
				"datefinal" => ($data["datefinal"] ??  null),
				"id" => ($data["id"] ??  null)
            ]
		
        ]);
    }

	/**
     * @param array|null $data
     */
    public function cashFlow(?array $data): void
    {
        $head = $this->seo->render(
            "Minhas despesas - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );
		
		//CHART
        $chartDataPeriod = (new AppInvoice())->chartDataPeriod($this->user,($data ??  null ));
	
		$totalbalancewallet = (new AppInvoice())->totalBalanceByPeriod($this->user,($data ??  null ));

		$wallet = (new AppWallet())
            ->find("application_id = :application_id", "application_id={$this->user->application_id}")
            ->order("wallet")
            ->fetch(true);
			
        echo $this->view->render("cashflow", [
            "user" => $this->user,
            "head" => $head,
			"data" => $data,
			"chart" => $chartDataPeriod,
            "totalbalancewallet" => $totalbalancewallet,
			"wallet" => $wallet,
            "filter" => (object)[
                "dateinitial" => ($data["dateinitial"] ??  null),
				"datefinal" => ($data["datefinal"] ??  null)
            ]
		
        ]);
    }
	
	/**
     * @param array $data
     * @throws \Exception
     */
    public function balanceFilter(array $data): void
    {
		
		$dateinitial = (!empty($data["dateinitial"]) ? $data["dateinitial"] : "all");
		$datefinal = (!empty($data["datefinal"]) ? $data["datefinal"] : "all");

		$redirect = "fluxodecaixa";
		$json["redirect"] = url("/work/{$redirect}/{$dateinitial}/{$datefinal}");
		echo json_encode($json);
	
    }
	
	/**
     * APP Work
     */
    public function relatorio(?array $data): void
    {
		
		$options = new Options();
		/**$options->(__DIR__ . "/../../themes/" . CONF_VIEW_WORK . "/");*/
	
		$options->setIsRemoteEnabled(true);
		$dompdf = new Dompdf($options);
		
		$walletr = (new AppWallet())
            ->find("application_id = :application_id", "application_id={$this->user->application_id}")->fetch();
	
		$html = $this->view->render("relatorio", [
            "user" => $this->user,	
            "invoices" => (new AppInvoice())->filterInvoices($this->user,($data ?? null)),
            "walletr" => $walletr->balance($this->user) 

        ]);
		
		$dompdf->loadHtml("{$html}");
		$dompdf->setPaper('A4');
		$dompdf->render();
		$dompdf->stream("relatorio.php", ["Attachment" => false]);
		
    }
	
	/**
     * APP Work
     */
    public function cashFlowReport(?array $data): void
    {
		
		$options = new Options();
		/**$options->(__DIR__ . "/../../themes/" . CONF_VIEW_WORK . "/");*/
	
		$options->setIsRemoteEnabled(true);
		$dompdf = new Dompdf($options);
			
		$totalbalancewallet = (new AppInvoice())->totalBalanceByPeriod($this->user,($data ??  null ));
		
		$wallet = (new AppWallet())
            ->find("application_id = :application_id", "application_id={$this->user->application_id}")
            ->order("wallet")
            ->fetch(true);
			
        $html = $this->view->render("cashflowreport", [
            "user" => $this->user,
			"data" => $data,
            "totalbalancewallet" => $totalbalancewallet,
			"wallet" => $wallet
            	
        ]);
		
		$dompdf->loadHtml("{$html}");
		$dompdf->setPaper('A4');
		$dompdf->render();
		$dompdf->stream("fluxodecaixa.php", ["Attachment" => false]);
	
    }
	
    /**
     * APP fixed
     */
    public function fixed(): void
    {
        $head = $this->seo->render(
            "Minhas contas fixas - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        $whereWallet = "";
        if ((new Session())->has("walletfilter")) {
            $whereWallet = "AND wallet_id = " . (new Session())->walletfilter;
        }

        echo $this->view->render("recurrences", [
            "head" => $head,
            "invoices" => (new AppInvoice())->find("user_id = :user AND type IN('fixed_income', 'fixed_expense') {$whereWallet}",
                "user={$this->user->id}")->fetch(true)
        ]);
    }

    /**
     * @param array|null $data
     */
    public function wallets(?array $data): void
    {
        //create
        if (!empty($data["wallet"]) && !empty($data["wallet_name"])) {

            //PREMIUM RESOURCE Cobranaça
            /** $subscribe = (new AppSubscription())->find("user_id = :user AND status != :status",
                "user={$this->user->id}&status=canceled");

            if (!$subscribe->count()) {
                $this->message->error("Desculpe {$this->user->first_name}, para criar novas carteiras é preciso ser PRO. Confira abaixo...")->flash();
                echo json_encode(["redirect" => url("/app/assinatura")]);
                return;
            }  */
			
			if (!empty($data["project_id"])){
			
				$wallet = new AppWallet();		
				$wallet->user_id = $this->user->id;
				$wallet->application_id = $this->user->application_id;
				$wallet->project = filter_var($data["project_id"], FILTER_SANITIZE_STRIPPED);
				$wallet->wallet = filter_var($data["wallet_name"], FILTER_SANITIZE_STRIPPED);
			
				if (!$wallet->save()) {
					$json["message"] = $wallet->message()->render();
					echo json_encode($json);
					return;	
				}
				echo json_encode(["reload" => true]);
				return;
				
			}else{
				
				$wallet = new AppWallet();		
				$wallet->user_id = $this->user->id;
				$wallet->application_id = $this->user->application_id;
				$wallet->wallet = filter_var($data["wallet_name"], FILTER_SANITIZE_STRIPPED);
			
				if (!$wallet->save()) {
					$json["message"] = $wallet->message()->render();
					echo json_encode($json);
					return;	
				}
				echo json_encode(["reload" => true]);
				return;

			}

        }

        //edit
        if (!empty($data["wallet"]) && !empty($data["wallet_edit"])) {
            $wallet = (new AppWallet())->find("application_id = :application_id AND id = :id",
                "application_id={$this->user->application_id}&id={$data["wallet"]}")->fetch();

            if ($wallet) {
                $wallet->wallet = filter_var($data["wallet_edit"], FILTER_SANITIZE_STRIPPED);
                $wallet->save();
            }

            echo json_encode(["wallet_edit" => true]);
            return;
        }

        //delete
        if (!empty($data["wallet"]) && !empty($data["wallet_remove"])) {
            $wallet = (new AppWallet())->find("application_id = :application_id AND id = :id",
                "application_id={$this->user->application_id}&id={$data["wallet"]}")->fetch();

            if ($wallet) {
                $wallet->destroy();
                (new Session())->unset("walletfilter");
            }

            echo json_encode(["wallet_remove" => true]);
            return;
        }

        $head = $this->seo->render(
            "Minhas carteiras - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        $wallets = (new AppWallet())
            ->find("application_id = :application_id AND status = 'active'", "application_id={$this->user->application_id}")
            ->order("wallet")
            ->fetch(true);

        echo $this->view->render("wallets", [
            "head" => $head,
            "wallets" => $wallets
        ]);
    }
	
	/**
     * @param array|null $data
     */
    public function walletEdit(?array $data): void
    {
		
		$works = (new Works());
		
		//create
        if (!empty($data["action"]) && $data["action"] == "update") {
			
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
			$walletUdate = (new AppWallet())->findById($data["id"]);
			$walletUdate->wallet = $data["wallet"];
			$walletUdate->status = $data["status"];
			
            if (!$walletUdate->save()) {
				
                $json["message"] = $workUdate->message()->render();
                echo json_encode($json);
                return;
				
            }
			
            $this->message->success("Carteira Atualizada")->flash();
            echo json_encode(["reload" => true]);
            return;
        }
		
        $walletEdit = null;
		
        if (!empty($data["id"])) {
            $walletId = filter_var($data["id"], FILTER_VALIDATE_INT);
            $walletEdit = (new AppWallet())->findById($walletId);
        }

        $head = $this->seo->render(	
		   "Atualizar a Carteira",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
			
        );
	
        echo $this->view->render("wallet-edit", [
            "head" => $head,
			"walletedit" => $walletEdit,
			"works" => $works,
		
		]);
    }
	
	
	/**
     * @param array|null $data
     */
    public function walletsInactive(?array $data): void
    {
		
		$wallets = (new AppWallet())
           ->find("application_id = :application_id AND status='finished'", "application_id={$this->user->application_id}")
           ->order("wallet")
           ->fetch(true);
		   
		$search = null;

        $all = ("all");
		$pager = new Pager(url("/work/carteirasinativas/{$all}/"));
        $pager->pager(10, 10, (!empty($data["page"]) ? $data["page"] : 1));
        $pager->pager(10, 10, (!empty($data["page"]) ? $data["page"] : 1));
	   
		//delete
        if (!empty($data["wallet"]) && !empty($data["wallet_remove"])) {
            $wallet = (new AppWallet())->find("application_id = :application_id AND id = :id",
                "application_id={$this->user->application_id}&id={$data["wallet"]}")->fetch();

            if ($wallet) {
                $wallet->destroy();
                (new Session())->unset("walletfilter");
            }

            echo json_encode(["wallet_remove" => true]);
            return;
        }
	  
        $head = $this->seo->render(
			"Lista de Carteiras Finalziadas ",
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );
		
        echo $this->view->render("walletsinactive", [
            "head" => $head,
            "wallets" => $wallets,
			"paginator" => $pager->render()
			
        ]);
    }
	
    /**
     * @param array $data
     */
    public function launch(array $data): void
    {
        if (request_limit("applaunch", 20, 60 * 5)) {
            $json["message"] = $this->message->warning("Foi muito rápido {$this->user->first_name}! Por favor aguarde 5 minutos para novos lançamentos.")->render();
            echo json_encode($json);
            return;
        }

        $invoice = new AppInvoice();

        $data["value"] = (!empty($data["value"]) ? str_replace([".", ","], ["", "."], $data["value"]) : 0);
        if (!$invoice->launch($this->user, $data)) {
			
            $json["message"] = $invoice->message()->render();
            echo json_encode($json);
            return;
        }

        $type = ($invoice->type == "income" ? "receita" : "despesa");
        $this->message->success("Tudo certo, sua {$type} foi lançada com sucesso")->flash();

        $json["reload"] = true;
        echo json_encode($json);
    }

    /**
     * @param array $data
     * @throws \Exception
     */
    public function support(array $data): void
    {
        if (empty($data["message"])) {
            $json["message"] = $this->message->warning("Para enviar escreva sua mensagem.")->render();
            echo json_encode($json);
            return;
        }

        if (request_limit("appsupport", 3, 60 * 5)) {
            $json["message"] = $this->message->warning("Por favor, aguarde 5 minutos para enviar novos contatos, sugestões ou reclamações")->render();
            echo json_encode($json);
            return;
        }

        if (request_repeat("message", $data["message"])) {
            $json["message"] = $this->message->info("Já recebemos sua solicitação {$this->user->first_name}. Agradecemos pelo contato e responderemos em breve.")->render();
            echo json_encode($json);
            return;
        }

        $subject = date_fmt() . " - {$data["subject"]}";
        $message = filter_var($data["message"], FILTER_SANITIZE_STRING);

        $view = new View(__DIR__ . "/../../shared/views/email");
        $body = $view->render("mail", [
            "subject" => $subject,
            "message" => str_textarea($message)
        ]);

        (new Email())->bootstrap(
            $subject,
            $body,
            CONF_MAIL_SUPPORT,
            "Suporte " . CONF_SITE_NAME
        )->queue($this->user->email, "{$this->user->first_name} {$this->user->last_name}");

        $this->message->success("Recebemos sua solicitação {$this->user->first_name}. Agradecemos pelo contato e responderemos em breve.")->flash();
        $json["reload"] = true;
        echo json_encode($json);
    }
	
	/**
     * @param array $data
     */
    public function onpaid(array $data): void
    {
        $invoice = (new AppInvoice())
            ->find("user_id = :user AND id = :id", "user={$this->user->id}&id={$data["invoice"]}")
            ->fetch();

        if (!$invoice) {
            $this->message->error("Ooops! Ocorreu um erro ao atualizar o lançamento :/")->flash();
            $json["reload"] = true;
            echo json_encode($json);
            return;
        }
			
        $invoice->status = ($invoice->status == "paid" ? "unpaid" : "paid");
        $invoice->save();

        $y = date("Y");
        $m = date("m");
        if (!empty($data["date"])) {
            list($m, $y) = explode("/", $data["date"]);
        }

        $json["onpaid"] = (new AppInvoice())->balanceMonth($this->user, $y, $m, $invoice->type);
        echo json_encode($json);
    }
	
	/**
     * @param array $data
     */
    public function onpaidincome(array $data): void
    {
         $invoice = (new AppInvoice())
            ->find("user_id = :user AND id = :id", "user={$this->user->id}&id={$data["invoice"]}")
            ->fetch();
				
		$walletid = (new AppWallet())
            ->find("user_id = :user AND id = :id", "user={$this->user->id}&id={$invoice->wallet_id}")->fetch();
			
        if (!$invoice) {
            $this->message->error("Ooops! Ocorreu um erro ao atualizar o lançamento :/")->flash();
            $json["reload"] = true;
            echo json_encode($json);
            return;
        }
		
        $invoice->status = ($invoice->status == "paid" ? "unpaid" : "paid");
        $invoice->save();

        $y = date("Y");
        $m = date("m");
        if (!empty($data["date"])) {
            list($m, $y) = explode("/", $data["date"]);
        }

		$json["onpaid"] = (new AppInvoice())->balanceProject($this->user, $y, $m, $invoice->type, $walletid);       
		echo json_encode($json);
    }
	
	
	/**
     * @param array $data
     */
    public function onpaidexpense(array $data): void
    {
		$invoice = (new AppInvoice())
            ->find("id = :id AND application_id = :application_id", "id={$data["invoice"]}&application_id={$this->user->application_id}")
            ->fetch();
				
		$walletid = (new AppWallet())
            ->find("id = :id AND application_id = :application_id", "id={$invoice->wallet_id}&application_id={$this->user->application_id}")->fetch();
				
        if (!$invoice) {
            $this->message->error("Ooops! Ocorreu um erro ao atualizar o lançamento :/")->flash();
            $json["reload"] = true;
            echo json_encode($json);
            return;
        }
		
        $invoice->status = ($invoice->status == "paid" ? "unpaid" : "paid");
        $invoice->save(); 
       
        $y = date("Y");
        $m = date("m");
        if (!empty($data["date"])) {
            list($m, $y) = explode("/", $data["date"]);
        }

		$json["onpaid"] = (new AppInvoice())->balanceProject($this->user, $y, $m, $invoice->type, $walletid);       
		echo json_encode($json);
		
    }
	
	
    /**
     * @param array $data
     */
    public function invoice(array $data): void
    {
        if (!empty($data["update"])) {
            $invoice = (new AppInvoice())->find("application_id = :application_id AND id = :id",
                "application_id={$this->user->application_id}&id={$data["invoice"]}")->fetch();

            if (!$invoice) {
                $json["message"] = $this->message->error("Ooops! Não foi possível carregar a fatura {$this->user->first_name}. Você pode tentar novamente.")->render();
                echo json_encode($json);
                return;
            }

            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
           
		    $check = \DateTime::createFromFormat("Y-m-d", $data["due_day"]);
			
			if (!$check || $check->format("Y-m-d") != $data["due_day"]) {
				
				$json["message"] = $this->message->error("O vencimento da fatura não tem um formato válido")->render();
                echo json_encode($json);
                return;
							
			}
			
			$invoice->user_id = $this->user->id;
			$invoice->application_id = $this->user->application_id;
			$due_day = $data["due_day"];
            $invoice->category_id = $data["category"];
            $invoice->description = $data["description"];
            $invoice->due_at = $due_day;
            $invoice->value = str_replace([".", ","], ["", "."], $data["value"]);
            $invoice->wallet_id = $data["wallet"];
            $invoice->status = $data["status"];

            if (!$invoice->save()) {
                $json["message"] = $invoice->message()->before("Ooops! ")->after(" {$this->user->first_name}.")->render();
                echo json_encode($json);
                return;
            }
			
            if (!$invoice->save()) {
                $json["message"] = $invoice->message()->before("Ooops! ")->after(" {$this->user->first_name}.")->render();
                echo json_encode($json);
                return;
            }
			
            $invoiceOf = (new AppInvoice())->find("application_id = :application_id AND invoice_of = :of",
                "application_id={$this->user->application_id}&of={$invoice->id}")->fetch(true);

            if (!empty($invoiceOf) && in_array($invoice->type, ["fixed_income", "fixed_expense"])) {
                foreach ($invoiceOf as $invoiceItem) {
                    if ($data["status"] == "unpaid" && $invoiceItem->status == "unpaid") {
                        $invoiceItem->destroy();
                    } else {
						
		
                      	$due_day = $data["due_day"];
                        $invoiceItem->category_id = $data["category"];
                        $invoiceItem->description = $data["description"];
                        $invoiceItem->wallet_id = $data["wallet"];

                        if ($invoiceItem->status == "unpaid") {
                            $invoiceItem->value = str_replace([".", ","], ["", "."], $data["value"]);
                            $invoiceItem->due_at = $due_day;
                        }

                        $invoiceItem->save();
                    }
                }
            }

            $json["message"] = $this->message->success("Pronto {$this->user->first_name}, a atualização foi efetuada com sucesso!")->render();
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            "Aluguel - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        $invoice = (new AppInvoice())->find("application_id = :application_id AND id = :invoice",
            "application_id={$this->user->application_id}&invoice={$data["invoice"]}")->fetch();

        if (!$invoice) {
            $this->message->error("Ooops! Você tentou acessar uma fatura que não existe")->flash();
            redirect("/app");
        }

        echo $this->view->render("invoice", [
            "head" => $head,
            "invoice" => $invoice,
            "wallets" => (new AppWallet())
                ->find("application_id = :application_id", "application_id={$this->user->application_id}", "id, wallet")
                ->order("wallet")
                ->fetch(true),
            "categories" => (new AppCategory())
                ->find("application_id = :application AND type = :type", "type={$invoice->category()->type}&application={$this->user->application_id}")
                ->order("order_by, name")
                ->fetch(true)
        ]);
    }
	

	/**
     * @param array|null $data
     */
    public function BalanceByPeriodMonthYear(?array $data): void
    {
        $head = $this->seo->render(
            "Minhas despesas - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );
		
		//CHART
        $chartDataPeriod = (new AppInvoice())->chartDataPeriod($this->user,($data ??  null));
		$balanceByPeriodMonthYear = (new AppInvoice())->balanceByPeriodMonthYear($this->user,($data ??  null));
		
		$wallet = (new AppWallet())
            ->find("application_id = :application_id", "application_id={$this->user->application_id}")
            ->order("wallet")
            ->fetch(true);
			
        echo $this->view->render("balanceperiod", [
            "user" => $this->user,
            "head" => $head,
			"data" => $data,
			"chart" => $chartDataPeriod,
            "balance" => $balanceByPeriodMonthYear,
			"wallet" => $wallet,
            "filter" => (object)[
                "dateinitial" => ($data["dateinitial"] ??  null),
				"datefinal" => ($data["datefinal"] ??  null)
            ]
		
        ]);
    }
	
	/**
     * @param array $data
     * @throws \Exception
     */
    public function filterPeriodMonthYear(array $data): void
    {
      
        $dateinitial = (!empty($data["dateinitial"]) ? $data["dateinitial"] : "all");
		$datefinal = (!empty($data["datefinal"]) ? $data["datefinal"] : "all");
		$redirect = "balançofinanceiro";
		$json["redirect"] = url("/work/{$redirect}/{$dateinitial}/{$datefinal}");
		echo json_encode($json);
		
    } 
	
	/**
     * APP BalanceByPeriodMonthYearReport
     */
    public function BalanceByPeriodMonthYearReport(?array $data): void
    {
		
		$options = new Options();
		/**$options->(__DIR__ . "/../../themes/" . CONF_VIEW_WORK . "/");*/
	
		$options->setIsRemoteEnabled(true);
		$dompdf = new Dompdf($options);
		
		//CHART
        $chartDataPeriod = (new AppInvoice())->chartDataPeriod($this->user,($data ??  null));
		$balanceByPeriodMonthYear = (new AppInvoice())->balanceByPeriodMonthYear($this->user,($data ??  null));
		
		$wallet = (new AppWallet())
            ->find("application_id = :application_id", "application_id={$this->user->application_id}")
            ->order("wallet")
            ->fetch(true);
			
        $html = $this->view->render("balanceperiodreport", [
            "user" => $this->user,
			"data" => $data,
			"chart" => $chartDataPeriod,
            "balance" => $balanceByPeriodMonthYear,
			"wallet" => $wallet   
        ]);
		
		$dompdf->loadHtml("{$html}");
		$dompdf->setPaper('A4');
		$dompdf->render();
		$dompdf->stream("fluxodecaixa.php", ["Attachment" => false]);
	
    }
	
	
	
	
    /**
     * @param array $data
     */
    public function remove(array $data): void
    {
        $invoice = (new AppInvoice())->find("application_id = :application_id AND id = :invoice",
            "application_id={$this->user->application_id}&invoice={$data["invoice"]}")->fetch();

        if ($invoice) {
            $invoice->destroy();
        }

        $this->message->success("Tudo pronto {$this->user->first_name}. O lançamento foi removido com sucesso!")->flash();
        $json["redirect"] = url("/work");
        echo json_encode($json);
    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function profile(?array $data): void
    {
        if (!empty($data["update"])) {
            list($d, $m, $y) = explode("/", $data["datebirth"]);
            $user = (new User())->findById($this->user->id);
            $user->first_name = $data["first_name"];
            $user->last_name = $data["last_name"];
            $user->genre = $data["genre"];
            $user->datebirth = "{$y}-{$m}-{$d}";
            $user->document = preg_replace("/[^0-9]/", "", $data["document"]);

            if (!empty($_FILES["photo"])) {
                $file = $_FILES["photo"];
                $upload = new Upload();

                if ($this->user->photo()) {
                    (new Thumb())->flush("storage/{$this->user->photo}");
                    $upload->remove("storage/{$this->user->photo}");
                }

                if (!$user->photo = $upload->image($file, "{$user->first_name} {$user->last_name} " . time(), 360)) {
                    $json["message"] = $upload->message()->before("Ooops {$this->user->first_name}! ")->after(".")->render();
                    echo json_encode($json);
                    return;
                }
            }

            if (!empty($data["password"])) {
                if (empty($data["password_re"]) || $data["password"] != $data["password_re"]) {
                    $json["message"] = $this->message->warning("Para alterar sua senha, informa e repita a nova senha!")->render();
                    echo json_encode($json);
                    return;
                }

                $user->password = $data["password"];
            }

            if (!$user->save()) {
                $json["message"] = $user->message()->render();
                echo json_encode($json);
                return;
            }

            $json["message"] = $this->message->success("Pronto {$this->user->first_name}. Seus dados foram atualizados com sucesso!")->render();
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            "Meu perfil - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("profile", [
            "head" => $head,
            "user" => $this->user,
            "photo" => ($this->user->photo() ? image($this->user->photo, 360, 360) :
                theme("/assets/images/avatar.jpg", CONF_VIEW_APP))
        ]);
    }

    public function signature(?array $data): void
    {
        $head = $this->seo->render(
            "Assinatura - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("signature", [
            "head" => $head,
            "subscription" => (new AppSubscription())
                ->find("user_id = :user AND status != :status", "user={$this->user->id}&status=canceled")
                ->fetch(),
            "orders" => (new AppOrder())
                ->find("user_id = :user", "user={$this->user->id}")
                ->order("created_at DESC")
                ->fetch(true),
            "plans" => (new AppPlan())
                ->find("status = :status", "status=active")
                ->order("name, price")
                ->fetch(true)
        ]);
    }

    /**
     * APP LOGOUT
     */
    public function logout(): void
    {
        $this->message->info("Você saiu com sucesso " . Auth::user()->first_name . ". Volte logo :)")->flash();

        Auth::logout();
        redirect("/entrar");
    }
	
	 /**
     * APP LOGOUT Work
     */
    public function workLogout(): void
    {
        $this->message->info("Você saiu com sucesso " . Auth::user()->first_name . ". Volte logo :)")->flash();

        Auth::logout();
        redirect("/work-entrar");
    }
	
	
	 /**
     * APP LOGOUT Work
     */
    public function project(?array $data): void
    {
		$project = null;
		$teste = null;
		
        if (!empty($data["project_id"])) {
			
            $projectId = filter_var($data["project_id"], FILTER_VALIDATE_INT);
            $project = (new Works())->findById($projectId);
	
        }

		$chartDataPeriod = (new AppInvoice())->chartDataProject($this->user, $project->date_initial, $project->date_final );

		$stage = (new Stage())->find("application_id = :application AND work_id = :work_id","application={$this->user->application_id}&work_id={$project->id}");
		$tasks = (new Task())->find("application_id = :application AND work_id = :work_id","application={$this->user->application_id}&work_id={$project->id}");
		$stageCategory = (new StageCategory())->find("application_id = :application ","application={$this->user->application_id}");
		$fileProjects =(new ProjectFile())->find("application_id= :application AND project = :work_id","application={$this->user->application_id}&work_id={$project->id}");
				
		$walletsproject = (new AppWallet())
            ->find("application_id = :application_id AND project = :project", "application_id={$this->user->application_id}&project={$project->id}")->fetch();
			
		$walletsproject2 = (new AppWallet())
            ->find("application_id = :application_id AND wallet = :wallet", "application_id={$this->user->application_id}&wallet={$project->name}")->fetch(true);
		
		$walletsproject3 = (new AppWallet())
            ->find("application_id = :application_id AND wallet = :wallet", "application_id={$this->user->application_id}&wallet={$project->name}");
			
		$head = $this->seo->render(
		   "Projeto"  ,
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );
		
        echo $this->view->render("project", [
            "head" => $head,
			"project" => $project,
			"user" => $this->user,
			"chart" => $chartDataPeriod,
			"stageCategory" => $stageCategory->order("id asc")->fetch(true),
			"stage" => $stage->order("id asc")->fetch(true),
			"tasks" => $tasks->order("id asc")->fetch(true),
			"fileProjects" => $fileProjects->order("id asc")->fetch(true),
			"walletsproject" =>  $walletsproject,	
			"income" => (new AppInvoice())->find("application_id = :application ","application={$this->user->application_id}"),
			"expense" => (new AppInvoice())->find("application_id = :application ","application={$this->user->application_id}"),
            "atualizar" => $atualizar = (new AppInvoice())
			
		]);

    }
	
	/**
     * APP Work
     */
    public function cronograma(?array $data): void
    {
		$options = new Options();
		/**$options->(__DIR__ . "/../../themes/" . CONF_VIEW_WORK . "/");*/
	
		$options->setIsRemoteEnabled(true);
		$dompdf = new Dompdf($options);

		$project = null;
		$teste = null;
		
		if (!empty($data["project_id"])) {			
            $projectId = filter_var($data["project_id"], FILTER_VALIDATE_INT);
            $project = (new Works())->findById($projectId);
			
        }
		
		$stage = (new Stage())->find("application_id = :application AND work_id = :work_id","application={$this->user->application_id}&work_id={$project->id}");
		$tasks = (new Task())->find("application_id = :application AND work_id = :work_id","application={$this->user->application_id}&work_id={$project->id}");
		
		$head = $this->seo->render(
		   "Projeto"  ,
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );
		
		$html = $this->view->render("cronograma", [
			"head" => $head,
			"project" => $project,
			"user" => $this->user,
			"stage" => $stage->order("id")->fetch(true),
			"tasks" => $tasks->order("id")->fetch(true),
            "atualizar" => $atualizar = (new AppInvoice())
			
		]);
		
		$dompdf->loadHtml("{$html}");
		$dompdf->setPaper('A4');
		$dompdf->render();
		$dompdf->stream("cronograma.pdf", ["Attachment" => false]);
		
    }
	
	/**
     * APP Modal modal Import Invoices
     */
    public function modalImportCronograma(array $data): void
    {	
	
		if ($_FILES["cover"]["name"] != '') {
			$allowed_extension = array('xls', 'csv', 'xlsx');
			$file_array = explode(".", $_FILES["cover"]["name"]);
			$file_extension = end($file_array);
			
			if (in_array($file_extension, $allowed_extension)) {
				$inputFileName = time() . '.' . $file_extension;
				move_uploaded_file($_FILES['cover']['tmp_name'], $inputFileName);
			
				$inputFileType = IOFactory::identify($inputFileName);
				$reader = IOFactory::createReader($inputFileType);
				$spreadsheet = $reader->load($inputFileName);
				
				unlink($inputFileName);
				
				$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
				$description = $spreadsheet->getActiveSheet()->getCell('A1')->getFormattedValue();
				$category = $spreadsheet->getActiveSheet()->getCell('B1')->getFormattedValue();
				$value = $spreadsheet->getActiveSheet()->getCell('C1')->getFormattedValue();
				$type = $spreadsheet->getActiveSheet()->getCell('D1')->getFormattedValue();
				$due_at = $spreadsheet->getActiveSheet()->getCell('E1')->getFormattedValue();
				$status = $spreadsheet->getActiveSheet()->getCell('F1')->getFormattedValue();

				if (($description == "TIPO") && ($category == "Descrição")  && ($date_initial == "Data de Início") && ($date_final == "Data de Términio	")) {
	
					array_shift($sheetData);
					foreach($sheetData as $columnspreadsheet){
											
						$spreadsheetdata  = [
							'description'	=>	$columnspreadsheet["A"],
							'category'		=>	$columnspreadsheet["B"],
							'value'		    =>	$columnspreadsheet["C"],
							'type'			=>	$columnspreadsheet["D"],
							'due_at'		=>	$columnspreadsheet["E"],	
							'status'		=>	$columnspreadsheet["F"],
						];
						
						if ($spreadsheetdata["type"] == "RECEITA") {
							$type = "income";
			
						} else if ($spreadsheetdata["type"] == "DESPESA") {
							$type = "expense";
						}
						
						$categoryfind = (new AppCategory())->findByName($spreadsheetdata["category"], $this->user->application_id);
						
						if (!$categoryfind) {
							$categoryCreate = (new AppCategory())->bootstrap(
								$this->user->id,
								$this->user->application_id,
								$type,
								$spreadsheetdata["category"],
							)->save();
		
						}
					
						$wallet = $data['id'];
						$invoice = new AppInvoice();
						
						if (!$invoice->importExcel($this->user, $spreadsheetdata, $wallet)) {
							$json["message"] = $invoice->message()->render();
							echo json_encode($json);
							return;
							
						}

					}		
				}	
				$json["message"] = $this->message->success("Faturas Importadas com sucesso!")->render();
				echo json_encode($json);
				return;
					
			} else {	
				$json["message"] = $this->message->error("Somente Arquivos nos Formtatos .xls .csv or .xlsx são aceitos")->render();
				echo json_encode($json);
				return;
				
			}
		} else {
			$json["message"] = $this->message->error("Por Favor Escolha um Arquivo")->render();
			echo json_encode($json);
			return;
		}
		
    }
	
	
	/**
     * @param array|null $data
    */
    public function atualizar(?array $data): void
    {
        
		$projectatualizar = null;
		
        if (!empty($data["id"])) {
            $projectId = filter_var($data["id"], FILTER_VALIDATE_INT);
            $projectatualizar = (new Works())->findById($projectId);	
        }
		$atualizarwallet = (new AppWallet())->find("application_id = :application_id AND wallet = :wallet",
                "application_id={$this->user->application_id}&wallet={$projectatualizar->name}")->fetch();
		
        //WALLET
		$atualizar = (new AppInvoice())->balanceWallet($atualizarwallet);
		$atualizar->valor = str_price($projectatualizar->projectcost - $atualizar->expense);
        $atualizar->wallet = str_price($atualizar->wallet);
        $atualizar->status = ($atualizar->balance == "positive" ? "gradient-green" : "gradient-red");
        $atualizar->income = str_price($atualizar->income);
        $atualizar->expense = str_price($atualizar->expense);
        $json["atualizar"] = $atualizar;

        echo json_encode($json);
    }
	
	/**
     * APP Work
     */
    public function work(?array $data): void
    {
		$works = (new Works())->find("application_id = :application","application={$this->user->application_id}");	
		$search = null;
        $all = "all";
        $pager = new Pager(url("/work/works/{$all}/"));
        $pager->pager($works->count(),20, (!empty($data["page"]) ? $data["page"] : 1));
		
		//delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $workDelete = (new Works())->findById($data["work_id"]);

            if (!$workDelete) {
                $this->message->error("Você tentou deletar um projeto que não existe")->flash();
                echo json_encode(["redirect" => url("/work/works")]);
                return;
				
            }
			
            $workDelete->destroy();
            $this->message->success("O projeto foi excluído com sucesso...")->flash();
            echo json_encode(["redirect" => url("/work/works")]);
            return;	
			
        }
		 
		$head = $this->seo->render(
		    "Lista de Projetos",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("works", [
            "head" => $head,
            "works" => $works->order("id asc")->limit($pager->limit())->offset($pager->offset())->fetch(true),
			"paginator" => $pager->render(),
        ]);
			
    }

	/**
     * APP Work
     */
    public function workAdd(?array $data): void
    {
		$customers = (new Customer())->find("application_id = :application","application={$this->user->application_id}");	
		$statuses =(new Status())->find();			

		//create
        if (!empty($data["action"]) && $data["action"] == "create") {
			
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
			$workCreate = new Works();	
			$workCreate->user_id = $this->user->id;					
            $workCreate->application_id = $this->user->application_id;
			$workCreate->customer_id = $data["customer_id"];
			$workCreate->name = $data["name"];
			$workCreate->address_street = $data["address_street"];
			$workCreate->address_number = $data["address_number"];
			$workCreate->address_neighborhood = $data["address_neighborhood"];
			$workCreate->address_complement = $data["address_complement"];
			$workCreate->address_postalcode = preg_replace("/[^0-9]/", "", $data["address_postalcode"]);
			$workCreate->address_city = $data["address_city"];
			$workCreate->address_state = $data["address_state"];
			$workCreate->address_country = $data["address_country"];
			$workCreate->observation = $data["observation"];
			$workCreate->date_initial = $data["date_initial"];
			$workCreate->date_final = $data["date_final"];
			$workCreate->projectcost = str_replace([".", ","], ["", "."], $data["projectcost"]);
			$workCreate->status = $data["status"];
		
				if (!$workCreate->save()) {
					var_dump($workCreate);
					$json["message"] = $workCreate->message()->render();
					echo json_encode($json);
					return;	
				}
					
			$json["message"] = $this->message->success("Cadastro Realizado com Sucesso!")->render();
            echo json_encode($json);
            return;
          
        }
				
        $head = $this->seo->render(
			"Cadastrar Projeto",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("works-add", [
            "head" => $head,
			"customers" => $customers->order("name")->fetch(true),
   			"statuses" => $statuses->order("name")->fetch(true)
        ]);

    }
	
	/**
     * APP Work
     */
    public function workEdit(?array $data): void
    {
		$customers = (new Customer())->find("application_id = :application","application={$this->user->application_id}");	
		$statuses =(new Status())->find();			

		//create
        if (!empty($data["action"]) && $data["action"] == "update") {
			
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
			$workUdate = (new Works())->findById($data["work_id"]);
			$workUdate->customer_id = $data["customer_id"];
			$workUdate->name = $data["name"];
			$workUdate->address_street = $data["address_street"];
			$workUdate->address_number = $data["address_number"];
			$workUdate->address_neighborhood = $data["address_neighborhood"];
			$workUdate->address_complement = $data["address_complement"];
			$workUdate->address_postalcode = preg_replace("/[^0-9]/", "", $data["address_postalcode"]);
			$workUdate->address_city = $data["address_city"];
			$workUdate->address_state = $data["address_state"];
			$workUdate->address_country = $data["address_country"];
			$workUdate->observation = $data["observation"];
			$workUdate->date_initial = $data["date_initial"];
			$workUdate->date_final = $data["date_final"];
			$workUdate->projectcost = str_replace([".", ","], ["", "."], $data["projectcost"]);

			$workUdate->status = $data["status"];
			
            if (!$workUdate->save()) {
				var_dump($workUdate);
                $json["message"] = $workUdate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Atualizar Projeto")->flash();
            echo json_encode(["reload" => true]);
            return;
        }
		
        $workEdit = null;
		
        if (!empty($data["work_id"])) {
            $workId = filter_var($data["work_id"], FILTER_VALIDATE_INT);
            $workEdit = (new Works())->findById($workId);
        }

        $head = $this->seo->render(
		
		   "Atualizar Projeto",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
			
        );
	
        echo $this->view->render("works-edit", [
		
            "head" => $head,
			"work" => $workEdit,
			"customers" => $customers->order("name")->fetch(true),
   			"statuses" => $statuses->order("name")->fetch(true)	
			
		]);
    }
	
	/**
     * APP Customer
     */
    public function customer(?array $data): void
    {
		$customers = (new Customer())->find("application_id = :application","application={$this->user->application_id}");	
        $all = "all";
        $pager = new Pager(url("/work/customer/{$all}/"));
        $pager->pager($customers->count(),20, (!empty($data["page"]) ? $data["page"] : 1));
		
		//delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $customerDelete = (new Customer())->findById($data["customer_id"]);

            if (!$customerDelete) {
                $this->message->error("Você tentnou deletar um fornecedor que não existe")->flash();
                echo json_encode(["redirect" => url("/work/customer")]);
                return;
				
            }
  
            $customerDelete->destroy();
            $this->message->success("O Cliente foi excluído com sucesso...")->flash();
            echo json_encode(["redirect" => url("/work/customer")]);
            return;	
			
        }
		
		$head = $this->seo->render(
			"Clientes Cadastrados",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("customer", [
            "head" => $head,
            "customers" => $customers->order("id")->limit($pager->limit())->offset($pager->offset())->fetch(true),
			"paginator" => $pager->render(),
        ]);

    }

	/**
     * Customer Add
     */
    public function customerAdd(?array $data): void
    {
		//create
        if (!empty($data["action"]) && $data["action"] == "create"){
			
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
			$customerCreate = new Customer();	
			$customerCreate->user_id = $this->user->id;					
            $customerCreate->application_id = $this->user->application_id;				
			$customerCreate->name = $data["name"];
			$customerCreate->document = preg_replace("/[^0-9]/", "", $data["document"]);
			$customerCreate->email = $data["email"];
			$customerCreate->contact = $data["contact"];
			$customerCreate->phone1 = preg_replace("/[^0-9]/", "", $data["phone1"]);
			$customerCreate->mobile = preg_replace("/[^0-9]/", "", $data["mobile"]);
			$customerCreate->phone2 = preg_replace("/[^0-9]/", "", $data["phone2"]);
			$customerCreate->fax = preg_replace("/[^0-9]/", "",  $data["fax"]);
			$customerCreate->address_street = $data["address_street"];
			$customerCreate->address_number = $data["address_number"];
			$customerCreate->address_neighborhood = $data["address_neighborhood"];
			$customerCreate->address_complement = $data["address_complement"];
			$customerCreate->address_postalcode = preg_replace("/[^0-9]/", "", $data["address_postalcode"]);
			$customerCreate->address_city = $data["address_city"];
			$customerCreate->address_state = $data["address_state"];
			$customerCreate->address_country = $data["address_country"];
			$customerCreate->observation = $data["observation"];

				if (!$customerCreate->save()) {

					$json["message"] = $customerCreate->message()->render();
					echo json_encode($json);
					return;	
				}
				
			$json["message"] = $this->message->success("Cadastro Realizado com sucesso!")->render();
            echo json_encode($json);
            return;
          
        }
		
        $head = $this->seo->render(
			"Cadastrar Cliente",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("customer-add", [
            "head" => $head
        ]);
	
    }
	
	/**
     * Customer Edit
     */
    public function customerEdit(?array $data): void
    {
		 //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $customerUpdate = (new Customer())->findById($data["customer_id"]);			
			$customerUpdate->name = $data["name"];
			$customerUpdate->document = preg_replace("/[^0-9]/", "", $data["document"]);
			$customerUpdate->email = $data["email"];
			$customerUpdate->contact = $data["contact"];
			$customerUpdate->phone1 = preg_replace("/[^0-9]/", "", $data["phone1"]);
			$customerUpdate->mobile = preg_replace("/[^0-9]/", "", $data["mobile"]);
			$customerUpdate->phone2 = preg_replace("/[^0-9]/", "", $data["phone2"]);
			$customerUpdate->fax = preg_replace("/[^0-9]/", "",  $data["fax"]);
			$customerUpdate->address_street = $data["address_street"];
			$customerUpdate->address_number = $data["address_number"];
			$customerUpdate->address_neighborhood = $data["address_neighborhood"];
			$customerUpdate->address_complement = $data["address_complement"];
			$customerUpdate->address_postalcode = preg_replace("/[^0-9]/", "", $data["address_postalcode"]);
			$customerUpdate->address_city = $data["address_city"];
			$customerUpdate->address_state = $data["address_state"];
			$customerUpdate->address_country = $data["address_country"];
			$customerUpdate->observation = $data["observation"];

            if (!$customerUpdate->save()) {
                $json["message"] = $customerUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Cliente atualizado com sucesso...")->flash();
            echo json_encode(["reload" => true]);
            return;
        }
		
        $customerEdit = null;
        if (!empty($data["customer_id"])) {
            $customerId = filter_var($data["customer_id"], FILTER_VALIDATE_INT);
            $customerEdit = (new Customer())->findById($customerId);
        }

        $head = $this->seo->render(
			"Atualizar Cliente",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );
	
        echo $this->view->render("customer-edit", [
            "head" => $head,
			"customer" => $customerEdit          
		]);
    }
	
	/**
     * APP Stage
     */
    public function stage(?array $data): void
    {
		$projectId = filter_var($data["id"], FILTER_VALIDATE_INT);
        $project = (new Works())->findById($projectId);
		$stages = (new StageCategory())->find("application_id = :application","application={$this->user->application_id}");
		$stages = (new Works())->find("application_id = :application AND work_id = :work_id ","application={$this->user->application_id}&work_id={$projectId}");			
		$search = null;
        $all = "all";
        $pager = new Pager(url("/stage/{$all}/"));
        $pager->pager($stages->count(),20, (!empty($data["page"]) ? $data["page"] : 1));
		
		//delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $stageDelete = (new Stage())->findById($data["id"]);

            if (!$stageDelete) {
				
                $this->message->error("Você tentnou deletar uma etapa que não existe")->flash();
                echo json_encode(["redirect" => url("/work/stage")]);
                return;
				
            }
  
            $stageDelete->destroy();

            $this->message->success("A etapa foi excluído com sucesso...")->flash();
            echo json_encode(["redirect" => url("/work/stage")]);
            return;	
			
        }
		
		$head = $this->seo->render(
			"Etapas",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("stage",[
            "head" => $head,
			"search" => $search,
            "stages" => $stages->order("id asc")->limit($pager->limit())->offset($pager->offset())->fetch(true),
			"paginator" => $pager->render(),
        ]);
			
    }
	
	
	/**
     * APP Stage Add
     */
    public function stageAdd(?array $data): void
    {
		
	    $stageCategory = (new StageCategory())->find("application_id = :application","application={$this->user->application_id}");	
		//create
        if (!empty($data["action"]) && $data["action"] == "create") {
			
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
			$stageCreate = new Stage();	
			$stageCreate->user_id = $this->user->id;					
            $stageCreate->application_id = $this->user->application_id;
			$stageCreate->work_id = $this->user->application_id;
			$stageCreate->stage_name = $data["stage_name"];
			$stageCreate->date_initial = $data["date_initial"];
			$stageCreate->date_final = $data["date_final"];
			$stageCreate->duration = $data["duration"];
			$stageCreate->annotations = $data["annotations"];
			$stageCreate->status = $data["status"];
			
				if (!$stageCreate->save()) {
					$json["message"] = $stageCreate->message()->render();
					echo json_encode($json);
					return;	
				}	
				
			$json["message"] = $this->message->success("Etapa Cadastrada com Sucesso!")->render();
            echo json_encode($json);
            return; 
        }
		
        $head = $this->seo->render(
		    "Cadastrar Etapas",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("stage-add", [
            "head" => $head,
			"stageCategory" => $stageCategory->order("name")->fetch(true)  
        ]);
    }
	
	/**
     * APP Modal Stage
     */
    public function modalStage(array $data): void
    {	
		//create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
			$stageCreate = new Stage();	
			$stageCreate->user_id = $this->user->id;					
            $stageCreate->application_id = $this->user->application_id;
			$stageCreate->work_id = $data["work"];
			$stageCreate->stage_name = $data["stage_name"];
			$stageCreate->date_initial = $data["date_initial"];
			$stageCreate->date_final = $data["date_final"];
			$dateinitial = $data["date_initial"];
			$datefinal = $data["date_final"];
			$start = new \DateTime($dateinitial);
			$end = new \DateTime($datefinal);
			$diff = $start->diff($end);
			$stageCreate->duration = floor($diff->days);
			$stageCreate->annotations = $data["annotations"];
			$stageCreate->status = $data["status"];
		
				if (!$stageCreate->save()) {
					var_dump($stageCreate);
					$json["message"] = $stageCreate->message()->render();
					echo json_encode($json);
					return;	
				}	
				
			$this->message->success("Etapa Cadastrada com Sucesso!")->flash();
			$json["reload"] = true;
			echo json_encode($json);	
				
        }
           
        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $stageUpdate = (new Stage())->findById($data["id"]);
			$stageUpdate->stage_name = $data["stage_name"];
			$stageUpdate->date_initial = $data["date_initial"];
			$stageUpdate->date_final = $data["date_final"];
			$dateinitial = $data["date_initial"];
			$datefinal = $data["date_final"];
			$start = new \DateTime($dateinitial);
			$end = new \DateTime($datefinal);
			$diff = $start->diff($end);
			$stageUpdate->duration = floor($diff->days);
			$stageUpdate->annotations = $data["annotations"];
			$stageUpdate->status = $data["status"];
			
            if (!$stageUpdate->save()) {
                $json["message"] = $stageUpdate->message()->render();
				echo json_encode($json);
				return;	
            }
	
            $this->message->success("Etapa Atualizada com Sucesso..")->flash();
            echo json_encode(["reload" => true]);
            return;
        }

        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
			
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $stageDelete = (new Stage())->findById($data["stage_id"]);

            if (!$stageDelete) {
                $this->message->error("Você tentou deletar uma etapa que não existe")->flash();
                 echo json_encode(["reload" => true]);
                return;
            }
			
            $stageDelete->destroy();
            $this->message->success("Etapa Excluída com Sucesso..")->flash();
            echo json_encode(["reload" => true]);
            return;
        }
    }
	
	/**
     * APP  Stage Status 
     */
    public function stagestatus(array $data): void
    {	
       $stage = (new Stage())
            ->find("user_id = :user AND id = :id", "user={$this->user->id}&id={$data["stages"]}")
            ->fetch();
			
		$stage->status = ($stage->status == "active" ? "finished" : "active");
        $stage->save();
		
		
		$json["stagestatus"] = (new Stage())->status($this->user,$stage->id);
		echo json_encode($json);
		
    }
	
	/**
     * APP Task Status
     */
    public function taskstatus(array $data): void
    {	
       $task = (new Task())
            ->find("user_id = :user AND id = :id", "user={$this->user->id}&id={$data["task"]}")
            ->fetch();
			
		$task->status = ($task->status == "active" ? "finished" : "active");
        $task->save();
		
		
		$json["taskstatus"] = (new Task())->status($this->user,$task->id);
		echo json_encode($json);
		
    }
	
	/**
     * APP Modal Task
     */
    public function modalTask(array $data): void
    {	
			
		//create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
			$taskCreate = new Task();	
			$taskCreate->user_id = $this->user->id;					
            $taskCreate->application_id = $this->user->application_id;
			$taskCreate->work_id = $data["work"];
			$taskCreate->task_name = $data["task_name"];
			$taskCreate->stage_name = $data["stage_name"];
			$taskCreate->date_initial = $data["date_initial"];
			$taskCreate->date_final = $data["date_final"];
			$dateinitial = $data["date_initial"];
			$datefinal = $data["date_final"];
			$start = new \DateTime($dateinitial);
			$end = new \DateTime($datefinal);
			$diff = $start->diff($end);
			$taskCreate->duration = floor($diff->days);
			$taskCreate->annotations = $data["annotations"];
			$taskCreate->status = $data["status"];
		
				if (!$taskCreate->save()) {
					$json["message"] = $taskCreate->message()->render();
					echo json_encode($json);
					return;	
				}	
				
			$this->message->success("Tarefa Cadastrada com Sucesso!")->flash();
			$json["reload"] = true;
			echo json_encode($json);	
				
        }
           
        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $taskUpdate = (new Task())->findById($data["id"]);
			$taskUpdate->stage_name = $data["stage_name"];
			$taskUpdate->task_name = $data["task_name"];
			$taskUpdate->date_initial = $data["date_initial"];
			$taskUpdate->date_final = $data["date_final"];
			$dateinitial = $data["date_initial"];
			$datefinal = $data["date_final"];
			$start = new \DateTime($dateinitial);
			$end = new \DateTime($datefinal);
			$diff = $start->diff($end);
			$taskUpdate->duration = floor($diff->days);
			$taskUpdate->annotations = $data["annotations"];
			$taskUpdate->status = $data["status"];
			
            if (!$taskUpdate->save()) {
				
                $json["message"] = $taskUpdate->message()->render();
				echo json_encode($json);
				return;	
            }
		
            $this->message->success("Tarefa Atualizada com Sucesso..")->flash();
            echo json_encode(["reload" => true]);
            return;
        }

        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
			
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $taskDelete = (new Task())->findById($data["task_id"]);

            if (!$taskDelete) {
				
                $this->message->error("Você tentou deletar uma tarefa que não existe")->flash();
                echo json_encode(["reload" => true]);
                return;
            }
			
            $taskDelete->destroy();
            $this->message->success("Tarefa Excluída com Sucesso..")->flash();
            echo json_encode(["reload" => true]);
            return;
        }
		
    }
	
	
	/**
     * APP Modal Project
     */
    public function modalProjectFile(array $data): void
    {	
			
		//create
        if (!empty($data["action"]) && $data["action"] == "create") {
			
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
			$projectFileCreate = new ProjectFile();		
			$projectFileCreate->user_id = $this->user->id;	
		    $projectFileCreate->application_id = $this->user->application_id;
			$projectFileCreate->project = $data["project"];			
            $projectFileCreate->title = $data["title"];
            $projectFileCreate->uri = str_slug($projectFileCreate->title);
            $projectFileCreate->subtitle = $data["subtitle"];
            $projectFileCreate->status = $data["status"];
			$projectFileCreate->description = $data["description"];	
			
			//upload cover
            if (!empty($_FILES["cover"])) {
                $file = $_FILES["cover"];
                $upload = new Upload();
                $file = $upload->userFile($file,$projectFileCreate->application_id, $projectFileCreate->project, $projectFileCreate->title);

                if (!$file) {
					
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $projectFileCreate->cover = $file;
            }

            if (!$projectFileCreate->save()) {
				var_dump($projectFileCreate);
                $json["message"] = $projectFileCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Arquivo Cadastrado com Sucesso!")->flash();
            $json["reload"] = true;
			echo json_encode($json);	
			
        }
           
        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
			
			$data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
			$projectFileUpdate = (new ProjectFile())->findById($data["id"]);		
			$projectFileUpdate->title = $data["title"];
			$projectFileUpdate->uri = str_slug($projectFileUpdate->title);
			$projectFileUpdate->subtitle = $data["subtitle"];
			$projectFileUpdate->status = $data["status"];
			$projectFileUpdate->description = $data["description"];
			
			
			//upload cover
            if (!empty($_FILES["cover"])) {
                $files = $_FILES["cover"];
                $upload = new Upload();
                $file = $upload->file($files, $projectFileUpdate->title);

                if (!$file) {
					
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $projectFileUpdate->cover = $file;
            }
			
            if (!$projectFileUpdate->save()) {
				
                $json["message"] = $projectFileUpdate->message()->render();
				echo json_encode($json);
				return;	
            }
		
            $this->message->success("Arquivo Atualizado com Sucesso..")->flash();
            echo json_encode(["reload" => true]);
            return;
        }

		//delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
			
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $projectFileDelete = (new ProjectFile())->findById($data["project"]);

            if (!$projectFileDelete) {
                $this->message->error("Você tentou excluir um post que não existe ou já foi removido")->flash();
                echo json_encode(["reload" => true]);
                return;
            }

            if ($projectFileDelete->cover && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$projectFileDelete->cover}")) {
                unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$projectFileDelete->cover}");
                (new Thumb())->flush($projectFileDelete->cover);
            }

            $projectFileDelete->destroy();
            $this->message->success("O documento foi excluído com sucesso...")->flash();

            echo json_encode(["reload" => true]);
            return;
        }
		
    }
	
	/**
     * APP  projectFile 
     */
	public function projectFile(?array $data): void
    {
	  	
		if (!empty($data["project_id"])) {
			 
            $projectId = filter_var($data["project_id"], FILTER_VALIDATE_INT);
           	$projects =(new Works())->find("application_id= :application AND id= :projectId","application={$this->user->application_id}&project_id={$projectId}");
			
        }
		
	    $projectFiles =(new ProjectFile())->find("application_id= :application","application={$this->user->application_id}");
		$search = null;
        $all = ($search ?? "all");
        $pager = new Pager(url("/project-file/{$all}/"));
        $pager->pager($projectFiles->count(),$projectFiles->count(), (!empty($data["page"]) ? $data["page"] : 10));
		
		//delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $projectFileDelete = (new ProjectFile())->findById($data["id"]);

            if (!$projectFileDelete) {
                $this->message->error("Você tentou excluir um post que não existe ou já foi removido")->flash();
                echo json_encode(["reload" => true]);
                return;
            }

            if ($projectFileDelete->cover && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$equipmentFileDelete->cover}")) {
                unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$projectFileDelete->cover}");
                (new Thumb())->flush($projectFileDelete->cover);
            }

            $projectFileDelete->destroy();
            $this->message->success("O documento foi excluído com sucesso...")->flash();

            echo json_encode(["reload" => true]);
            return;
        }
		
		$head = $this->seo->render(
			"Lista de Arquivos",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("project-file", [
			"application_id" => $this->user->application_id,
            "head" => $head,
			"projectFiles" => $projectFiles->order("title")->limit($pager->limit())->offset($pager->offset())->fetch(true),
			"projects" => $projects->order("name")->fetch(true),
			"paginator" => $pager->render()
			      
        ]);
			 			
    }
	
	/**
     * APP projecttFileAdd
     */
    public function projecttFileAdd(?array $data): void
    {
		
		if (!empty($data["project_id"])) {
			 
            $projectId = filter_var($data["project_id"], FILTER_VALIDATE_INT);
           	$projects =(new Works())->find("application_id= :application AND id= :projectId","application={$this->user->application_id}&project_id={$projectId}");
			
        }

		//create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $projectFileAdd = new ProjecFile();
			$projectFileAdd->user_id = $this->user->id;	
		    $projectFileAdd->application_id = $this->user->application_id;
			$projectFileAdd->project = $data["project"];			
            $projectFileAdd->title = $data["title"];
            $projectFileAdd->uri = str_slug($projectFileAdd->title);
            $projectFileAdd->subtitle = $data["subtitle"];
            $projectFileAdd->status = $data["status"];
			$projectFileAdd->description = $data["description"];	
			
            //upload cover
            if (!empty($_FILES["cover"])) {
                $files = $_FILES["cover"];
                $upload = new Upload();
                $file = $upload->file($files, $projectFileAdd->title);

                if (!$file) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $projectFileAdd->cover = $file;
            }

            if (!$projectFileAdd->save()) {
                $json["message"] = $projectFileAdd->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Documento Salvo com Sucesso")->flash();
            $json["redirect"] = url("/work/project-file");
			
			
            echo json_encode($json);
            return;
        }
			     
        $head = $this->seo->render(
            "Cadastro de Arquivos",
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("project-file-add", [
            "head" => $head,
			"projects" => $projects->order("name")->fetch(true),

        ]);
		
    }
	
	/**
     * APP projectFileEdit
     */
    public function projectFileEdit(?array $data): void
    {
		$projects =(new Works())->find("application_id = :application","application={$this->user->application_id}");
		
		if (!empty($data["action"]) && $data["action"] == "update") 
		{
			    $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
				$projectFileUpdate = (new ProjectFile())->findById($data["id"]);
				$projectFileUpdate->project = $data["project"];			
				$projectFileUpdate->title = $data["title"];
				$projectFileUpdate->uri = str_slug($projectFileAdd->title);
				$projectFileUpdate->subtitle = $data["subtitle"];
				$projectFileUpdate->status = $data["status"];
				$projectFileUpdate->description = $data["description"];
				
				if (!$projectFileUpdate->save()) 
				{
					$json["message"] = $projectFileUpdate->message()->render();
					echo json_encode($json);
					return;
				}
				
				$json["message"] = $this->message->success("Vinculação  atualizada com sucesso!")->render();
				echo json_encode($json);
				return;
	
		}	
	
		$projectFileEdit = null;
		
        if (!empty($data["id"])) {
            $projectFileId = filter_var($data["id"], FILTER_VALIDATE_INT);
            $projectFileEdit = (new ProjectFile())->findById($projectFileId);
        }
	
		$head = $this->seo->render(
           "Atualizar Arquivo",
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        ); 
		
        echo $this->view->render("project-file-edit", [
            "head" => $head,
            "projectFile" => $projectFileEdit
        ]);		 
	
    }
	
	
	/**
     * APP Supplier
     */
    public function supplier(?array $data): void
    {
		$suppliers = (new Supplier())->find("application_id = :application","application={$this->user->application_id}");	
		$search = null;
        $all = "all";
        $pager = new Pager(url("/supplier/{$all}/"));
        $pager->pager($suppliers->count(),20, (!empty($data["page"]) ? $data["page"] : 1));
		
		//delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $supplierDelete = (new Supplier())->findById($data["id"]);

            if (!$supplierDelete) {
				
                $this->message->error("Você tentnou deletar um fornecedor que não existe")->flash();
                echo json_encode(["redirect" => url("/work/supplier")]);
                return;
				
            }
  
            $supplierDelete->destroy();

            $this->message->success("O fornecedor foi excluído com sucesso...")->flash();
            echo json_encode(["redirect" => url("/work/supplier")]);
            return;	
			
        }
		
		$head = $this->seo->render(
			"Fornecedores",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("supplier", [
            "head" => $head,
			"search" => $search,
            "suppliers" => $suppliers->order("name asc")->limit($pager->limit())->offset($pager->offset())->fetch(true),
			"paginator" => $pager->render(),
        ]);
			
    }
	
	/**
     * APP Supplier Add
     */
    public function supplierAdd(?array $data): void
    {
		
	    $suppliertype = (new ServiceCategory())->find("application_id = :application","application={$this->user->application_id}");	

		//create
        if (!empty($data["action"]) && $data["action"] == "create") {
			
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

			$supplierCreate = new Supplier();	
			$supplierCreate->user_id = $this->user->id;					
            $supplierCreate->application_id = $this->user->application_id;				
			$supplierCreate->name = $data["name"];
			$supplierCreate->document = preg_replace("/[^0-9]/", "", $data["document"]);
			$supplierCreate->email = $data["email"];
			$supplierCreate->site = $data["site"];
			$supplierCreate->supplier_type = $data["supplier_type"];
			$supplierCreate->contact = $data["contact"];
			$supplierCreate->phone1 = preg_replace("/[^0-9]/", "", $data["phone1"]);
			$supplierCreate->mobile = preg_replace("/[^0-9]/", "", $data["mobile"]);
			$supplierCreate->phone2 = preg_replace("/[^0-9]/", "", $data["phone2"]);
			$supplierCreate->fax = preg_replace("/[^0-9]/", "",  $data["fax"]);
			$supplierCreate->address_street = $data["address_street"];
			$supplierCreate->address_number = $data["address_number"];
			$supplierCreate->address_neighborhood = $data["address_neighborhood"];
			$supplierCreate->address_complement = $data["address_complement"];
			$supplierCreate->address_postalcode = preg_replace("/[^0-9]/", "", $data["address_postalcode"]);
			$supplierCreate->address_city = $data["address_city"];
			$supplierCreate->address_state = $data["address_state"];
			$supplierCreate->address_country = $data["address_country"];
			$supplierCreate->observation = $data["observation"];

				if (!$supplierCreate->save()) {
					$json["message"] = $supplierCreate->message()->render();
					echo json_encode($json);
					return;	
				}
				
			$json["message"] = $this->message->success("Cadastro Realizado com sucesso!")->render();
            echo json_encode($json);
            return;
          
        }
		
        $head = $this->seo->render(
			"Cadastrar Fornecedores",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("supplier-add", [
            "head" => $head,
			"suppliertype" => $suppliertype->order("name asc")->fetch(true)  
        ]);
    }
	
	/**
     * APP Supplier Edit
     */
	public function supplierEdit(?array $data): void
    {
		$suppliertype = (new ServiceCategory())->find("application_id = :application","application={$this->user->application_id}");	

		 //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $supplierUpdate = (new Supplier())->findById($data["supplier_id"]);
			$supplierUpdate->name = $data["name"];
			$supplierUpdate->document = preg_replace("/[^0-9]/", "", $data["document"]);
			$supplierUpdate->email = $data["email"];
			$supplierUpdate->site = $data["site"];
			$supplierUpdate->supplier_type = $data["supplier_type"];
			$supplierUpdate->contact = $data["contact"];
			$supplierUpdate->phone1 = preg_replace("/[^0-9]/", "", $data["phone1"]);
			$supplierUpdate->mobile = preg_replace("/[^0-9]/", "", $data["mobile"]);
			$supplierUpdate->phone2 = preg_replace("/[^0-9]/", "", $data["phone2"]);
			$supplierUpdate->fax = preg_replace("/[^0-9]/", "",  $data["fax"]);
			$supplierUpdate->address_street = $data["address_street"];
			$supplierUpdate->address_number = $data["address_number"];
			$supplierUpdate->address_neighborhood = $data["address_neighborhood"];
			$supplierUpdate->address_complement = $data["address_complement"];
			$supplierUpdate->address_postalcode = preg_replace("/[^0-9]/", "", $data["address_postalcode"]);
			$supplierUpdate->address_city = $data["address_city"];
			$supplierUpdate->address_state = $data["address_state"];
			$supplierUpdate->address_country = $data["address_country"];
			$supplierUpdate->observation = $data["observation"];

            if (!$supplierUpdate->save()) {
                $json["message"] = $supplierUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Fornecedor atualizado com sucesso...")->flash();
            echo json_encode(["reload" => true]);
            return;
        }


        $supplierEdit = null;
        if (!empty($data["supplier_id"])) {
            $supplierid = filter_var($data["supplier_id"], FILTER_VALIDATE_INT);
            $supplierEdit = (new Supplier())->findById($supplierid);
        }

        $head = $this->seo->render(
			"Atualizar Forncedores",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );
	
        echo $this->view->render("supplier-edit", [
            "head" => $head,
            "supplier" => $supplierEdit,
			"suppliertype" => $suppliertype->order("name asc")->fetch(true) 
        ]);

    }
	
	/**
     * APP  Employees
     */
	public function employee(?array $data): void
    {
		$occupations = (new OccupationCategory())->find("application_id = :application","application={$this->user->application_id}");
        $employees = (new Employee())->find("application_id = :application","application={$this->user->application_id}");	
		$search = null;
        $all = "all";
        $pager = new Pager(url("/employee/{$all}/"));
        $pager->pager($employees->count(),$employees->count(), (!empty($data["page"]) ? $data["page"] : 10));
		
		
		 //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $employeeDelete = (new Employee())->findById($data["id"]);

            if (!$employeeDelete) {
				
                $this->message->error("Você tentou deletar um funcionário que não existe")->flash();
                echo json_encode(["redirect" => url("/app/employee")]);
                return;
				
            }
  
            $employeeDelete->destroy();

            $this->message->success("O funcionário foi excluído com sucesso...")->flash();
            echo json_encode(["redirect" => url("/app/employee")]);
            return;	
			
        }
	    
		$head = $this->seo->render(
			"Lista de Funcionários",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("employee", [
            "head" => $head,
			"search" => $search,
		    "occupations" => $occupations,
            "employees" => $employees->order("name desc")->limit($pager->limit())->offset($pager->offset())->fetch(true),
			"paginator" => $pager->render(),
        ]);	
		
    }
	
	/**
     * APP  employee Addd
     */
    public function employeeAdd(?array $data): void
    {
		
		$occupations = (new OccupationCategory())->find("application_id = :application","application={$this->user->application_id}");	

		//create
        if (!empty($data["action"]) && $data["action"] == "create") {
			
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

			$employeeCreate = new Employee();	
			$employeeCreate->user_id = $this->user->id;					
            $employeeCreate->application_id = $this->user->application_id;				
			$employeeCreate->name = $data["name"];
			$employeeCreate->document = preg_replace("/[^0-9]/", "", $data["document"]);
			$employeeCreate->email = $data["email"];
			$employeeCreate->occupation_id = $data["occupation_id"];
			$employeeCreate->phone1 = preg_replace("/[^0-9]/", "", $data["phone1"]);
			$employeeCreate->mobile = preg_replace("/[^0-9]/", "", $data["mobile"]);
			$employeeCreate->phone2 = preg_replace("/[^0-9]/", "", $data["phone2"]);
			$employeeCreate->address_street = $data["address_street"];
			$employeeCreate->address_number = $data["address_number"];
			$employeeCreate->address_neighborhood = $data["address_neighborhood"];
			$employeeCreate->address_complement = $data["address_complement"];
			$employeeCreate->address_postalcode = preg_replace("/[^0-9]/", "", $data["address_postalcode"]);
			$employeeCreate->address_city = $data["address_city"];
			$employeeCreate->address_state = $data["address_state"];
			$employeeCreate->address_country = $data["address_country"];
			$employeeCreate->observation = $data["observation"];

				if (!$employeeCreate->save()) {
					var_dump($employeeCreate);
					$json["message"] = $employeeCreate->message()->render();
					echo json_encode($json);
					return;	
				}
				

			$json["message"] = $this->message->success("Funcionário Cadastrado com Sucesso!")->render();
            echo json_encode($json);
            return;
          
        }
		
        $head = $this->seo->render(
			"Cadastrar funcionários",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("employee-add", [
            "head" => $head,
			"occupations" => $occupations->order("name")->fetch(true)  
   
        ]);
		    
    }
	
	/**
     * APP Employee Edit
     */
	public function employeeEdit(?array $data): void
    {
		 $occupations = (new OccupationCategory())->find("application_id = :application","application={$this->user->application_id}");	

		 //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $employeeUpdate = (new Employee())->findById($data["id"]);
			$employeeUpdate->name = $data["name"];
			$employeeUpdate->document = preg_replace("/[^0-9]/", "", $data["document"]);
			$employeeUpdate->email = $data["email"];
			$employeeUpdate->occupation_id = $data["occupation_id"];
			$employeeUpdate->phone1 = preg_replace("/[^0-9]/", "", $data["phone1"]);
			$employeeUpdate->mobile = preg_replace("/[^0-9]/", "", $data["mobile"]);
			$employeeUpdate->phone2 = preg_replace("/[^0-9]/", "", $data["phone2"]);
			$employeeUpdate->address_street = $data["address_street"];
			$employeeUpdate->address_number = $data["address_number"];
			$employeeUpdate->address_neighborhood = $data["address_neighborhood"];
			$employeeUpdate->address_complement = $data["address_complement"];
			$employeeUpdate->address_city = $data["address_city"];
			$employeeUpdate->address_postalcode = preg_replace("/[^0-9]/", "", $data["address_postalcode"]);
			$employeeUpdate->address_state = $data["address_state"];
			$employeeUpdate->address_country = $data["address_country"];
			$employeeUpdate->observation = $data["observation"];

            if (!$employeeUpdate->save()) {
                $json["message"] = $employeeUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Funcionário atualizado com sucesso...")->flash();
            echo json_encode(["reload" => true]);
            return;
        }
		
        $employeeEdit = null;
        if (!empty($data["id"])) {
            $employeeId = filter_var($data["id"], FILTER_VALIDATE_INT);
            $employeeEdit = (new Employee())->findById($employeeId);
        }

        $head = $this->seo->render(
			"Atualizar Funcionários",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );
	
        echo $this->view->render("employee-edit", [
            "head" => $head,
			"occupations" => $occupations->order("name")->fetch(true), 
            "employee" => $employeeEdit
        ]);
		
    }
	
	/**
     * APP  equipment Qrcode
     */
	public function equipmentQrcode(?array $data): void
    {
		$equipmentQrcodes = (new EquipmentQrcode())->find("application_id = :application","application={$this->user->application_id}");
		$search = null;
        $all = "all";
        $pager = new Pager(url("/equipment-qrcode/{$all}/"));
        $pager->pager($equipmentQrcodes->count(),$equipmentQrcodes->count(), (!empty($data["page"]) ? $data["page"] : 10));
		
		
		 //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $equipmentQrcodeDelete = (new EquipmentQrcode())->findById($data["id"]);

            if (!$equipmentQrcodeDelete) {
				
                $this->message->error("Você tentou deletar um funcionário que não existe")->flash();
                echo json_encode(["redirect" => url("/app/equipment-qrcode")]);
                return;
				
            }
  
            $equipmentQrcodeDelete->destroy();

            $this->message->success("O QR Code foi excluído com sucesso...")->flash();
            echo json_encode(["redirect" => url("/app/equipment-qrcode")]);
            return;	
			
        }
	    
		$head = $this->seo->render(
			"Lista de Funcionários",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("equipment-qrcode", [
            "head" => $head,
			"search" => $search,
            "equipmentQrcodes" => $equipmentQrcodes->order("id")->limit($pager->limit())->offset($pager->offset())->fetch(true),
			"paginator" => $pager->render(),
        ]);	
		
		
    }
	
	/**
    * APP Qr Code ADD
    */
    public function equipmentQrcodeAdd(?array $data): void
    {
		$equipments = (new Equipment())->find("application_id = :application","application={$this->user->application_id}");	
	
        if (!empty($data["action"]) && $data["action"] == "create") {
			
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
			
			$create = new EquipmentQrcode();
            $create->user_id = $this->user->id;					
            $create->application_id = $this->user->application_id;					
		    $create->equipment_id = $data["equipment_id"];
			
			$create->status = $data["status"];
			
			$equipment = $create->getEquipment();
			$create->uri = str_slug($equipment->name);
			$qrcodeInfo= url("/qrcode/equipment-home/{$create->application_id}/{$create->equipment_id}/{$create->uri}");
			$qrcodeSupport= url("/qrcode/equipment/{$create->application_id}/{$create->equipment_id}/{$create->uri}");
			$qrcode = new QRC();
			
			$qrcode->qrcodeInfo($qrcodeInfo,$create->application_id,$create->equipment_id,$create->uri);
		    $qrcode->qrcodeSupport($qrcodeSupport,$create->application_id,$create->equipment_id,$create->uri);
			
			$info= url("/storage/qrcodeinfo/info_{$create->application_id}_{$create->equipment_id}_{$create->uri}.jpg");
			$support= url("/storage/qrcodesupport/support_{$create->application_id}_{$create->equipment_id}_{$create->uri}.jpg");
			
			$create->info = $info;
			$create->support = $support;

			if (!$create->save()) {
				$json["message"] = $create->message()->render();
				echo json_encode($json);
				return;
						
			}
			
			$json["message"] = $this->message->success("Cadastro Realizado com sucesso!")->render();
            echo json_encode($json);
            return;
		
        }
		
        $head = $this->seo->render(
			"Gerar Qrcode",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("equipment-qrcode-add", [
            "head" => $head,
			"equipments" => $equipments->order("name")->fetch(true),
			
        ]);
    }
	
	/**
     * APP Equipment Edit
     */
	 public function equipmentQrcodeEdit(?array $data): void
    {
		
		 //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $qrcodeUpdate = (new EquipmentQrcode())->findById($data["id"]);
			$qrcodeUpdate->status = $data["status"];
			
            if (!$qrcodeUpdate->save()) {
                $json["message"] = $qrcodeUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("O QR Code foi atualizado com sucesso...")->flash();
            echo json_encode(["reload" => true]);
            return;
        }

        $qrcodeEdit = null;
	
        if (!empty($data["id"])) {
            $qrcodeId = filter_var($data["id"], FILTER_VALIDATE_INT);
            $qrcodeEdit = (new EquipmentQrcode())->findById($qrcodeId);
			$qrcodeName = $qrcodeEdit->getEquipment();
        }

		$head = $this->seo->render(
			"Atualizar Qr Cpde",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );
        
        echo $this->view->render("equipment-qrcode-edit", [
            "head" => $head,
            "qrcodeEdit" => $qrcodeEdit,
			"qrcodeName" => $qrcodeName,
			
        ]);
    }
	
	/**
     * APP Equipments
     */
    public function equipment(?array $data): void
    {
		
		//search redirect
        if (!empty($data["s"])) {
            $s = str_search($data["s"]);
            echo json_encode(["redirect" => url("/app/equipment/{$s}/1")]);
            return;
        }

        $search = null;
		$equipments = (new Equipment())->find("application_id = :application","application={$this->user->application_id}");	

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $equipments = (new Equipment())->find("MATCH(name,localization,tag,status) AGAINST(:s)", "s={$search}");
            if (!$equipments->count()) {
                $this->message->info("Sua pesquisa não retornou resultados")->flash();
                redirect("/app/equipment");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/app/equipment/{$all}/"));
        $pager->pager($equipments->count(),5, (!empty($data["page"]) ? $data["page"] : 1));
		
		
		 //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $equipmentDelete = (new Equipment())->findById($data["id"]);

            if (!$equipmentDelete) {
				
                $this->message->error("Você tentnou deletar um usuário que não existe")->flash();
                echo json_encode(["redirect" => url("/app/equipment")]);
                return;
				
            }
  
            $equipmentDelete->destroy();

            $this->message->success("O equipamento foi excluído com sucesso...")->flash();
            echo json_encode(["redirect" => url("/app/equipment")]);
			

            return;
        }
			
		$head = $this->seo->render(
			"Lista de Equipamentos",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("equipment", [
            "head" => $head,
			"search" => $search,
            "equipments" => $equipments->order("name")->limit($pager->limit())->offset($pager->offset())->fetch(true),
			"paginator" => $pager->render()
        ]);
			
    }
	
	/**
    * APP add equipment
    */
    public function equipmentAdd(?array $data): void
    {
		$categories = (new EquipmentCategory())->find("application_id = :application","application={$this->user->application_id}");	
		$category_id = NULL;
		$suppliers = (new Supplier())->find("application_id = :application","application={$this->user->application_id}");	
		$supplier_id = NULL;
		
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
			
			$create = new Equipment();
            $create->user_id = $this->user->id;					
            $create->application_id = $this->user->application_id;					
		    $create->name = $data["name"];
			$create->category_id = $data["category_id"];
			$create->localization = $data["localization"];
			$create->tag = $data["tag"];
			$create->supplier_id = $data["supplier_id"];

				if (!$create->save()) {
					$json["message"] = $create->message()->render();
					echo json_encode($json);
					return;
				}

				
			$json["message"] = $this->message->success("Cadastro Realizado com sucesso!")->render();
            echo json_encode($json);
            return;
		
        }
		
        $head = $this->seo->render(
			"Cadastrar Equipamentos",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("equipment-add", [
            "head" => $head,
			"categories" => $categories->order("name")->fetch(true),
			"suppliers" => $suppliers->order("name")->fetch(true),     
        ]);
    }
	
	/**
     * APP Equipment Edit
     */
	 public function equipmentEdit(?array $data): void
    {
		$categories = (new EquipmentCategory())->find("application_id = :application","application={$this->user->application_id}");	
		$suppliers = (new Supplier())->find("application_id = :application","application={$this->user->application_id}");	

		 //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $equipmentUpdate = (new Equipment())->findById($data["id"]);
			$equipmentUpdate->name = $data["name"];
			$equipmentUpdate->category_id = $data["category_id"];
			$equipmentUpdate->supplier_id = $data["supplier_id"];
			$equipmentUpdate->localization = $data["localization"];
			$equipmentUpdate->tag = $data["tag"];
		
            if (!$equipmentUpdate->save()) {
                $json["message"] = $equipmentUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("O equipamento foi atualizado com sucesso...")->flash();
            echo json_encode(["reload" => true]);
            return;
        }

        $equipmentEdit = null;
		
        if (!empty($data["id"])) {
            $equipmentId = filter_var($data["id"], FILTER_VALIDATE_INT);
            $equipmentEdit = (new Equipment())->findById($equipmentId);
        }

		$head = $this->seo->render(
			"Atualizar Equipamentos",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );
        
        echo $this->view->render("equipment-edit", [
            "head" => $head,
            "equipments" => $equipmentEdit,
			"categories" => $categories->order("name")->fetch(true),
			"suppliers" => $suppliers->order("name")->fetch(true)
        ]);
    }
	
	public function equipmentWorker(?array $data): void
    {
	  	
		$employees =(new Employee())->find("application_id= :application","application={$this->user->application_id}");	
		$equipments =(new Equipment())->find("application_id= :application","application={$this->user->application_id}");
	    $equipmentworkers =(new EquipmentWorker())->find("application_id= :application","application={$this->user->application_id}");
		$search = null;
        $all = ($search ?? "all");
        $pager = new Pager(url("/equipment-worker/{$all}/"));
        $pager->pager($equipmentworkers->count(),$equipmentworkers->count(), (!empty($data["page"]) ? $data["page"] : 10));
		
		//delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $equipmenteorkerDelete = (new EquipmentWorker())->findById($data["id"]);

            if (!$equipmenteorkerDelete) {
  
                $this->message->error("Você tentnou deletar um fornecedor que não existe")->flash();
                echo json_encode(["redirect" => url("/app/equipment-worker")]);
                return;
				
            }
			
            $equipmenteorkerDelete->destroy();
            $this->message->success("O fornecedor foi excluído com sucesso...")->flash();
            echo json_encode(["redirect" => url("/app/equipment-worker")]);
            return;	
	
        }
		
		$head = $this->seo->render(
			"Lista de Fornecedores",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("equipment-worker", [
			"application_id" => $this->user->application_id,
            "head" => $head,
			"equipmentworkers" => $equipmentworkers->order("id")->limit($pager->limit())->offset($pager->offset())->fetch(true),
			"equipments" => $equipments->order("name")->fetch(true),
			"employees" => $employees->order("name")->fetch(true),
			"paginator" => $pager->render()
			      
        ]);
			 			
    }
	
	/**
     * APP add equipment
     */
    public function equipmentWorkerAdd(?array $data): void
    {
		
		$employees =(new Employee())->find("application_id = :application","application={$this->user->application_id}");	
		$equipments =(new Equipment())->find("application_id = :application","application={$this->user->application_id}");

        if (!empty($data["action"]) && $data["action"] == "create") {
        
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

				$equipmentWorkerAdd = new EquipmentWorker();
                $equipmentWorkerAdd->user_id = $this->user->id;	
				$equipmentWorkerAdd->application_id = $this->user->application_id;	
				$equipmentWorkerAdd->equipment_id = $data["equipment_id"];
				$equipmentWorkerAdd->employee_id = $data["employee_id"];
				$equipmentWorkerAdd->status = $data["status"];	
				$equipmentWorkerAdd->observation = $data["observation"];		
												
				if (!$equipmentWorkerAdd->save()) {
					
					$json["message"] = $equipmentWorkerAdd->message()->render();
					echo json_encode($json);
					return;
								
				}
		
			$json["message"] = $this->message->success("Cadastro Realizado com sucesso!")->render();
            echo json_encode($json);
            return;
			
		}
					     
        $head = $this->seo->render(
            "Cadastro de Manutenções",
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("equipment-worker-add", [
            "head" => $head,
			"equipments" => $equipments->order("name")->fetch(true),
			"employees" => $employees->order("name")->fetch(true)	

        ]);
		
    }
	
	
	/**
     * APP add equipment
     */
    public function equipmentWorkerEdit(?array $data): void
    {
		$employees =(new Employee())->find("application_id = :application","application={$this->user->application_id}");	
		$equipments =(new Equipment())->find("application_id = :application","application={$this->user->application_id}");
		
		if (!empty($data["action"]) && $data["action"] == "update") 
		{
			    $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
				$equipmentWorkerUpdate = (new EquipmentWorker())->findById($data["id"]);
				$equipmentWorkerUpdate->equipment_id = $data["equipment_id"];
				$equipmentWorkerUpdate->employee_id = $data["employee_id"];
				$equipmentWorkerUpdate->observation = $data["observation"];
				$equipmentWorkerUpdate->status = $data["status"];
				
				if (!$equipmentWorkerUpdate->save()) 
				{
					$json["message"] = $equipmentWorkerUpdate->message()->render();
					echo json_encode($json);
					return;
				}
				
				$json["message"] = $this->message->success("Vinculação  atualizada com sucesso!")->render();
				echo json_encode($json);
				return;
	
		}	
	
		$equipmentWorkerEdit = null;
		
        if (!empty($data["id"])) {
            $equipmentWorkerId = filter_var($data["id"], FILTER_VALIDATE_INT);
            $equipmentWorkerEdit = (new EquipmentWorker())->findById($equipmentWorkerId);
        }
	
		$head = $this->seo->render(
            "Atualizar Manutenções",
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        ); 
		
        echo $this->view->render("equipment-worker-edit", [
            "head" => $head,
            "equipmentworker" => $equipmentWorkerEdit
        ]);		 
	
    }
	
	public function equipmentHome(?array $data): void
    {
	    $equipmentFile =(new EquipmentFile())->find("application_id= :application AND equipment_id= :equipment_id ","application={$this->user->application_id}&equipment_id={$data["equipment_id"]}");
		$search = null;
        $all = ($search ?? "all");
        $pager = new Pager(url("/equipment-file/{$all}/"));
        $pager->pager($equipmentFile->count(),$equipmentFile->count(), (!empty($data["page"]) ? $data["page"] : 10));
	
		$head = $this->seo->render(
			"Lista de Fornecedores",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("equipment-home", [
            "head" => $head,
			"equipmentFiles" => $equipmentFile->order("title")->limit($pager->limit())->offset($pager->offset())->fetch(true),
			"paginator" => $pager->render()
			      
        ]);
			 			
    }
	
	/**
     * APP  equipmentFile 
     */
	public function equipmentFile(?array $data): void
    {
	  	
		$equipments =(new Equipment())->find("application_id= :application","application={$this->user->application_id}");
	    $equipmentFile =(new EquipmentFile())->find("application_id= :application","application={$this->user->application_id}");
		$search = null;
        $all = ($search ?? "all");
        $pager = new Pager(url("/equipment-file/{$all}/"));
        $pager->pager($equipmentFile->count(),$equipmentFile->count(), (!empty($data["page"]) ? $data["page"] : 10));
		

		//delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $equipmentFileDelete = (new EquipmentFile())->findById($data["id"]);

            if (!$equipmentFileDelete) {
                $this->message->error("Você tentou excluir um post que não existe ou já foi removido")->flash();
                echo json_encode(["reload" => true]);
                return;
            }

            if ($equipmentFileDelete->cover && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$equipmentFileDelete->cover}")) {
                unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$equipmentFileDelete->cover}");
                (new Thumb())->flush($equipmentFileDelete->cover);
            }

            $equipmentFileDelete->destroy();
            $this->message->success("O documento foi excluído com sucesso...")->flash();

            echo json_encode(["reload" => true]);
            return;
        }
		
		$head = $this->seo->render(
			"Lista de Fornecedores",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("equipment-file", [
			"application_id" => $this->user->application_id,
            "head" => $head,
			"equipmentFiles" => $equipmentFile->order("title")->limit($pager->limit())->offset($pager->offset())->fetch(true),
			"equipments" => $equipments->order("name")->fetch(true),
			"paginator" => $pager->render()
			      
        ]);
			 			
    }
	
	/**
     * APP equipmentFileAdd
     */
    public function equipmentFileAdd(?array $data): void
    {
		
		$equipments =(new Equipment())->find("application_id = :application","application={$this->user->application_id}");

		 //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $equipmentFileAdd = new EquipmentFile();
			$equipmentFileAdd->user_id = $this->user->id;	
		    $equipmentFileAdd->application_id = $this->user->application_id;
			$equipmentFileAdd->equipment_id = $data["equipment_id"];			
            $equipmentFileAdd->title = $data["title"];
            $equipmentFileAdd->uri = str_slug($equipmentFileAdd->title);
            $equipmentFileAdd->subtitle = $data["subtitle"];
            $equipmentFileAdd->status = $data["status"];
			$equipmentFileAdd->description = $data["description"];	
			
            //upload cover
            if (!empty($_FILES["cover"])) {
                $files = $_FILES["cover"];
                $upload = new Upload();
                $file = $upload->file($files, $equipmentFileAdd->title);

                if (!$file) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $equipmentFileAdd->cover = $file;
            }

            if (!$equipmentFileAdd->save()) {
				var_dump($equipmentFileAdd);

                $json["message"] = $equipmentFileAdd->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Documento Salvo com Sucesso")->flash();
            $json["redirect"] = url("/app/equipment-file");
			
			
            echo json_encode($json);
            return;
        }
		
			     
        $head = $this->seo->render(
            "Cadastro de Manutenções",
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("equipment-file-add", [
            "head" => $head,
			"equipments" => $equipments->order("name")->fetch(true),

        ]);
		
    }
	
	/**
     * APP equipmentFileEdit
     */
    public function equipmentFileEdit(?array $data): void
    {
		$equipments =(new Equipment())->find("application_id = :application","application={$this->user->application_id}");
		
		if (!empty($data["action"]) && $data["action"] == "update") 
		{
			    $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
				$equipmentFileUpdate = (new EquipmentFile())->findById($data["id"]);
				$equipmentFileUpdate->equipment_id = $data["equipment_id"];
				$equipmentFileUpdate->employee_id = $data["employee_id"];
				$equipmentFileUpdate->observation = $data["observation"];
				$equipmentFileUpdate->status = $data["status"];
				
				if (!$equipmentFileUpdate->save()) 
				{
					$json["message"] = $equipmentFileUpdate->message()->render();
					echo json_encode($json);
					return;
				}
				
				$json["message"] = $this->message->success("Vinculação  atualizada com sucesso!")->render();
				echo json_encode($json);
				return;
	
		}	
	
		$equipmentFileEdit = null;
		
        if (!empty($data["id"])) {
            $equipmentFileId = filter_var($data["id"], FILTER_VALIDATE_INT);
            $equipmentFileEdit = (new EquipmentFile())->findById($equipmentFileId);
        }
	
		$head = $this->seo->render(
            "Atualizar Manutenções",
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        ); 
		
        echo $this->view->render("equipment-file-edit", [
            "head" => $head,
            "equipmentFile" => $equipmentFileEdit
        ]);		 
	
    }
	
	/**
     * APP Equipmets Categories
     */
    public function equipmentCategory(?array $data): void
    {
		$categories = (new EquipmentCategory())->find("application_id = :application","application={$this->user->application_id}");	
		$search = null;
        $all = ($search ?? "all");
        $pager = new Pager(url("/equipment-category/{$all}/"));
        $pager->pager($categories->count(),$categories->count(), (!empty($data["page"]) ? $data["page"] : 10));
				
		//delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $categoryDelete = (new EquipmentCategory())->findById($data["id"]);

            if (!$categoryDelete) {
				
                $this->message->error("Você tentnou deletar uma categoria que não existe")->flash();
                echo json_encode(["redirect" => url("/app/equipment-category")]);
                return;
	
            }
			
            $categoryDelete->destroy();
			$this->message->success("A categoria foi excluída com sucesso...")->flash();
            echo json_encode(["reload" => true]);
            return;
			
     
        }
		
		$head = $this->seo->render(
			"Lista de Categorias de Equipamentos",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("equipment-category", [
            "head" => $head,
			"search" => $search,
            "categories" => $categories->order("name")->limit($pager->limit())->offset($pager->offset())->fetch(true),
			"paginator" => $pager->render(),
        ]);
		
		
    }
	
	/**
     * APP Add Equipmets Categories
     */
    public function equipmentCategoryAdd(?array $data): void
    {	
       //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

				$categoryCreate = new EquipmentCategory();			
				$categoryCreate->user_id = $this->user->id;	
				$categoryCreate->application_id = $this->user->application_id;					
				$categoryCreate->name = $data["name"];
				
				
				if (!$categoryCreate->save()) {
					$json["message"] = $categoryCreate->message()->render();
					echo json_encode($json);
					return;
				}

			$json["message"] = $this->message->success("Cadastro Realizado com sucesso!")->render();
            echo json_encode($json);
            return;
			
			
			
		}
				
       $head = $this->seo->render(
			"Cadastros de Categorias de Equipamentos",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("equipment-category-add", [
            "head" => $head,
        ]);
    }
	
	/**
     *APP Occupation Categories
     */
    public function occupationCategory(?array $data): void
    {
		$categories = (new OccupationCategory())->find("application_id = :application","application={$this->user->application_id}");	
		$search = null;
        $all = ($search ?? "all");
        $pager = new Pager(url("/occupation-category/{$all}/"));
        $pager->pager($categories->count(),10, (!empty($data["page"]) ? $data["page"] : 10));
		
		$head = $this->seo->render(
			"Lista de Funções Técnicas",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );
		
		//delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $categoryDelete = (new OccupationCategory())->findById($data["id"]);

            if (!$categoryDelete) {
				
                $this->message->error("Você tentnou deletar uma categoria que não existe")->flash();
                echo json_encode(["redirect" => url("/app/occupation-category")]);
                return;
	
            }
			
            $categoryDelete->destroy();
			$this->message->success("Categoria cadastrada com sucesso...")->flash();
            echo json_encode(["reload" => true]);
            return;
			
        }

        echo $this->view->render("occupation-category", [
            "head" => $head,
			"search" => $search,
            "categories" => $categories->order("name")->limit($pager->limit())->offset($pager->offset())->fetch(true),
			"paginator" => $pager->render(),
        ]);
			
    }
	
	/**
     * APP Add Occupation Categories
     */
    public function occupationCategoryAdd(?array $data): void
    {	
	
       //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

				$categoryCreate = new OccupationCategory();			
				$categoryCreate->user_id = $this->user->id;	
				$categoryCreate->application_id = $this->user->application_id;					
				$categoryCreate->name = $data["name"];
								
				if (!$categoryCreate->save()) {
					$json["message"] = $categoryCreate->message()->render();
					echo json_encode($json);
					return;
				}

			$json["message"] = $this->message->success("Cadastro Realizado com sucesso!")->render();
            echo json_encode($json);
            return;
					
		}
          
		$head = $this->seo->render(
			"Cadastro de Funções Técnicas",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("occupation-category-add", [
            "head" => $head,
        ]);
		
    }
		
	/**
     *Work Service Categories
     */
    public function serviceCategory(?array $data): void
    {
		$categories = (new ServiceCategory())->find("application_id = :application","application={$this->user->application_id}");	
		$search = null;
        $all = ($search ?? "all");
        $pager = new Pager(url("/service-category/{$all}/"));
        $pager->pager($categories->count(),$categories->count(), (!empty($data["page"]) ? $data["page"] : 10));
		
		
		//delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $categoryDelete = (new ServiceCategory())->findById($data["id"]);

            if (!$categoryDelete) {
				
                $this->message->error("Você tentnou deletar uma categoria que não existe")->flash();
                echo json_encode(["redirect" => url("/app/service-category")]);
                return;
	
            }
			
            $categoryDelete->destroy();
			$this->message->success("O categoria foi deletado com sucesso...")->flash();
            echo json_encode(["reload" => true]);
            return;
			
        }
		
		
		
		$head = $this->seo->render(
			"Lista de Categorias de Serviços",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("service-category",[
            "head" => $head,
			"search" => $search,
            "categories" => $categories->order("name")->limit($pager->limit())->offset($pager->offset())->fetch(true),
			"paginator" => $pager->render(),
        ]);
		
		
    }

	/**
     * Work  Service Categories Add
     */
    public function serviceCategoryAdd(?array $data): void
    {	
		
       //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

				$categoryCreate = new ServiceCategory();
				$categoryCreate->user_id = $this->user->id;	
				$categoryCreate->application_id = $this->user->application_id;					
				$categoryCreate->name = $data["name"];
				
				
				 if (!$categoryCreate->save()) {
					$json["message"] = $categoryCreate->message()->render();
					echo json_encode($json);
					return;
				 }

			$json["message"] = $this->message->success("Cadastro Realizado com sucesso!")->render();
            echo json_encode($json);
            return;
			
		}
          
		$head = $this->seo->render(
            "Cadastro de Categoria de Serviços",
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("service-category-add", [
            "head" => $head,
        ]);
		
    }
	
	/**
     *Work Stage Categories
     */
    public function supplierCategory(?array $data): void
    {
		$categories = (new SupplierType())->find("application_id = :application","application={$this->user->application_id}");	
		$search = null;
        $all = ($search ?? "all");
        $pager = new Pager(url("/supplier-category/{$all}/"));
        $pager->pager($categories->count(),20, (!empty($data["page"]) ? $data["page"] : 1));
		
		//delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $categoryDelete = (new SupplierType())->findById($data["id"]);

            if (!$categoryDelete) {
				
                $this->message->error("Você tentou deletar uma categoria que não existe")->flash();
                echo json_encode(["redirect" => url("/work/supplier-category")]);
                return;
	
            }
			
            $categoryDelete->destroy();
			$this->message->success("A categoria foi deletado com sucesso...")->flash();
            echo json_encode(["reload" => true]);
            return;
			
        }
	
		$head = $this->seo->render(
			"Categorias de Forncedores",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("supplier-category",[
            "head" => $head,
			"search" => $search,
            "categories" => $categories->order("name")->limit($pager->limit())->offset($pager->offset())->fetch(true),
			"paginator" => $pager->render(),
        ]);
		
		
    }
	
	/**
     * Work Stage Categories Add
     */
    public function supplierCategoryAdd(?array $data): void
    {	
	
       //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

				$categoryCreate = new SupplierType();
				$categoryCreate->user_id = $this->user->id;	
				$categoryCreate->application_id = $this->user->application_id;					
				$categoryCreate->name = $data["name"];
					
				 if (!$categoryCreate->save()) {
					$json["message"] = $categoryCreate->message()->render();
					echo json_encode($json);
					return;
				 }

			$json["message"] = $this->message->success("Cadastro Realizado com sucesso!")->render();
            echo json_encode($json);
            return;
			
		}
         
		$head = $this->seo->render(
            "Cadastro de Categoria de Forncedores",
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("supplier-category-add", [
            "head" => $head,
        ]);
		
    }
	
	/**
     *Work Stage Categories
     */
    public function Category(?array $data): void
    {
		$categories = (new AppCategory())->find("application_id = :application","application={$this->user->application_id}");	
		$search = null;
        $all = ($search ?? "all");
        $pager = new Pager(url("/work/category/{$all}/"));
        $pager->pager($categories->count(),20, (!empty($data["page"]) ? $data["page"] : 1));
		
		//delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $categoryDelete = (new StageCategory())->findById($data["id"]);

            if (!$categoryDelete) {
				
                $this->message->error("Você tentou deletar uma categoria que não existe")->flash();
                echo json_encode(["redirect" => url("/work/category")]);
                return;
	
            }
			
            $categoryDelete->destroy();
			$this->message->success("A categoria foi deletado com sucesso...")->flash();
            echo json_encode(["reload" => true]);
            return;
			
        }
	
		$head = $this->seo->render(
			"Categorias de Etapas",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("category",[
            "head" => $head,
			"search" => $search,
            "categories" => $categories->order("name asc")->limit($pager->limit())->offset($pager->offset())->fetch(true),
			"paginator" => $pager->render(),
        ]);
		
		
    }
	
	/**
     * Work Stage Categories Add
     */
    public function CategoryAdd(?array $data): void
    {	
	
       //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

				$categoryCreate = new AppCategory();
				$categoryCreate->user_id = $this->user->id;	
				$categoryCreate->application_id = $this->user->application_id;					
				$categoryCreate->name = $data["name"];
				$categoryCreate->type = $data["type"];

				
				 if (!$categoryCreate->save()) {
					 
					$json["message"] = $categoryCreate->message()->render();
					echo json_encode($json);
					return;
				 }

			$json["message"] = $this->message->success("Cadastro Realizado com sucesso!")->render();
            echo json_encode($json);
            return;
			
		}
         
		$head = $this->seo->render(
            "Cadastro de Categoria",
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("category-add", [
            "head" => $head,
        ]);
		
    }
	
	/**
     * APP  Occupation Categories Add
     */
    public function serviceCategoryEdit(?array $data): void
    {	
		
       if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
			$categoryUpdate = new ServiceCategory();	
			$categoryUpdate->name = $data["name"];
            $categoryUpdate->user_id = $data["user_id"];
		    $categoryUpdate->application_id = $data["application_id"];

		        if (!$categoryUpdate->save()) {
					
					$json["message"] = $categoryUpdate->message()->render();
					echo json_encode($json);
					
                return;
            }

            $json["message"] = $this->message->success("Cadastro Realizado com sucesso!")->render();
            echo json_encode($json);
            return;
        }

        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $categoryDelete = (new ServiceCategory())->findById($data["id"]);

            if (!$categoryDelete) {
				
                $this->message->error("Você tentnou deletar um usuário que não existe")->flash();
                echo json_encode(["redirect" => url("/app/user")]);
                return;
				
            }
  
            $categoryDelete->destroy();

            $this->message->success("O usuário foi excluído com sucesso...")->flash();
            echo json_encode(["redirect" => url("/app/category-edit/{id}")]);

            return;
        }

        $categoryEdit = null;
		
        if (!empty($data["id"])) {
            $categoryId = filter_var($data["id"], FILTER_VALIDATE_INT);
            $categoryEdit = (new ServiceCategory())->findById($categoryId);
        }

       $head = $this->seo->render(
			"Atualizar Funcinários",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );
		
        echo $this->view->render("service-category-edit", [
            "head" => $head,
            "category" => $categoryEdit

        ]);		  	 
			
    }
		
     /**
     * @param array $data
     * @throws \Exception
     */
    public function maintenanceSearch(array $data): void
    {	
        $service_id = (!empty($data["service_id"]) ? $data["service_id"] : "all");
	    $equipment_id = (!empty($data["equipment_id"]) ? $data["equipment_id"] : "all");
		$date = (!empty($data["date"]) ? $data["date"] : "all");	
        $redirect = $data["maintenancesearch"];
        $json["redirect"] = url("/app/{$redirect}/{$service_id}/{$equipment_id}/{$date}/1");
	    echo json_encode($json);

    }
	
	public function maintenance(?array $data): void
    {
	    $services =(new ServiceCategory())->find("application_id= :application","application={$this->user->application_id}");
		$suppliers =(new Supplier())->find("application_id= :application","application={$this->user->application_id}");		
		$employees =(new Employee())->find("application_id= :application","application={$this->user->application_id}");	
		$equipments =(new Equipment())->find("application_id= :application","application={$this->user->application_id}");
		$services =(new ServiceCategory())->find("application_id= :application","application={$this->user->application_id}");			
		$payments =(new Payment())->find();	
		$statuses =(new Status())->find();
						
		//delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $maintDelete = (new Maintenance())->findById($data["id"]);

            if (!$maintDelete) {
  
                $this->message->error("Você tentnou deletar um fornecedor que não existe")->flash();
                echo json_encode(["redirect" => url("/app/maintenance")]);
                return;
				
            }
			
            $maintDelete->destroy();
            $this->message->success("O fornecedor foi excluído com sucesso...")->flash();
            echo json_encode(["redirect" => url("/app/maintenance")]);
            return;	
			
        }
		
		$pager = (new Maintenance())->pag($this->user->application_id, ($data ?? null));		
		$limit = $pager->limit();
		$offset = $pager->offset();
			
		$head = $this->seo->render(
			"Lista de Fornecedores",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("maintenance", [
			"application_id" => $this->user->application_id,
            "head" => $head,
			"maintenances" => (new Maintenance())->filter($this->user->application_id,($data ?? null),$limit,$offset),	
			"suppliers" => $suppliers->order("name")->fetch(true),  
			"equipments" => $equipments->order("name")->fetch(true),
			"employees" => $employees->order("name")->fetch(true),
			"payments" => $payments->order("name")->fetch(true),
			"statuses" => $statuses->order("name")->fetch(true),
			"services" => $services->order("name")->fetch(true),
			"filter" => (object)[
                "equipment_id" => ($data["equipment_id"] ?? null),
				"service_id" => ($data["service_id"] ?? null)	
            ],
			"paginator" => $pager->render()		      
        ]);			 			
    }
	
	/**
     * APP Add Maintenance
     */
    public function maintenanceAdd(?array $data): void
    {
		$suppliers =(new Supplier())->find("application_id = :application","application={$this->user->application_id}");		
		$employees =(new Employee())->find("application_id = :application","application={$this->user->application_id}");	
		$equipments =(new Equipment())->find("application_id = :application","application={$this->user->application_id}");
		$services =(new ServiceCategory())->find("application_id = :application","application={$this->user->application_id}");			
		$payments =(new Payment())->find();	
		$statuses =(new Status())->find();
		$collaboratorCategory =(new CollaboratorCategory())->find("application_id = :application","application={$this->user->application_id}");

        if (!empty($data["action"]) && $data["action"] == "create") { 
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
			$newMaintenance = new Maintenance();
            $newMaintenance->user_id = $this->user->id;	
			$newMaintenance->application_id = $this->user->application_id;	
			$newMaintenance->equipment_id = $data["equipment_id"];
			$newMaintenance->service_id = $data["service_id"];
			$newMaintenance->status_id = $data["status_id"];
			$newMaintenance->maintenance_type = $data["maintenance_type"];
			$newMaintenance->date_initial = $data["date_initial"];
			$newMaintenance->time_initial = $data["time_initial"];
			$newMaintenance->date_final = $data["date_final"];
			$newMaintenance->time_final = $data["time_final"];
			$newMaintenance->annotations = $data["annotations"];
			$newMaintenance->type_collaborator = $data["type_collaborator"];
			$newMaintenance->collaborator_name = $data["collaborator_name"];	
			$newMaintenance->price = $data["price"];
												
			if (!$newMaintenance->save()) {	
				$json["message"] = $newMaintenance->message()->render();
				echo json_encode($json);
				return;
								
			}	
			$json["message"] = $this->message->success("Cadastro Realizado com sucesso!")->render();
            echo json_encode($json);
            return;
			
		}
					     
        $head = $this->seo->render(
            "Cadastro de Manutenções",
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("maintenance-add", [
            "head" => $head,
			"suppliers" => $suppliers->order("name")->fetch(true),  
			"equipments" => $equipments->order("name")->fetch(true),
			"employees" => $employees->order("name")->fetch(true),
			"payments" => $payments->order("name")->fetch(true),
			"statuses" => $statuses->order("name")->fetch(true),
			"services" => $services->order("name")->fetch(true),
			"collaboratorCategory" => $collaboratorCategory->order("name")->fetch(true),	
        ]);
    }
	
	/**
     * APP Edit Maintenance
     */
	public function maintenanceEdit(?array $data): void
    {
		$suppliers =(new Supplier())->find("application_id = :application","application={$this->user->application_id}");		
		$employees =(new Employee())->find("application_id = :application","application={$this->user->application_id}");	
		$equipments =(new Equipment())->find("application_id = :application","application={$this->user->application_id}");
		$services =(new ServiceCategory())->find("application_id = :application","application={$this->user->application_id}");			
		$payments =(new Payment())->find();	
		$statuses =(new Status())->find();
		$collaboratorCategory =(new CollaboratorCategory())->find("application_id = :application","application={$this->user->application_id}");

		if (!empty($data["action"]) && $data["action"] == "update") {	
			$data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
			$maintenanceUpdate = (new Maintenance())->findById($data["id"]);
			$maintenanceUpdate->equipment_id = $data["equipment_id"];
			$maintenanceUpdate->service_id = $data["service_id"];
			$maintenanceUpdate->status_id = $data["status_id"];
			$maintenanceUpdate->maintenance_type = $data["maintenance_type"];
			$maintenanceUpdate->date_initial = $data["date_initial"];
			$maintenanceUpdate->time_initial = $data["time_initial"];
			$maintenanceUpdate->date_final = $data["date_final"];
			$maintenanceUpdate->time_final = $data["time_final"];
			$maintenanceUpdate->annotations = $data["annotations"];
			$maintenanceUpdate->type_collaborator = $data["type_collaborator"];
			$maintenanceUpdate->collaborator_name = $data["collaborator_name"];	
			$maintenanceUpdate->price = $data["price"];
				
			if (!$maintenanceUpdate->save()) {
				$json["message"] = $maintenanceUpdate->message()->render();
				echo json_encode($json);
				return;
			}
				
			$json["message"] = $this->message->success("Manutenção atualizada com sucesso!")->render();
			echo json_encode($json);
			return;
		}	
	
		$maintenanceEdit = null;
		
        if (!empty($data["id"])) {
            $maintenanceId = filter_var($data["id"], FILTER_VALIDATE_INT);
            $maintenanceEdit = (new Maintenance())->findById($maintenanceId);
        }
	
		$head = $this->seo->render(
            "Atualizar Manutenções",
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        ); 
		
        echo $this->view->render("maintenance-edit", [
            "head" => $head,
            "maintenance" => $maintenanceEdit,			
			"suppliers" => $suppliers->order("name")->fetch(true),  
			"equipments" => $equipments->order("name")->fetch(true),
			"employees" => $employees->order("name")->fetch(true),
			"payments" => $payments->order("name")->fetch(true),
			"statuses" => $statuses->order("name")->fetch(true),
			"services" => $services->order("name")->fetch(true)
        ]);		 
    }
		
	/**
     * APP Home 
    */	
	public function homeview(?array $data): void
    {
		$events =(new Reservation())->find();	
		$suppliers =(new supplier())->find();	
		$head = $this->seo->render(
            CONF_SITE_NAME,
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );
		
        echo $this->view->render("homeview", [
            "head" => $head,
            "events" => $events->order("date_at")->fetch(true),
			"suppliers" => $suppliers->order("name")->fetch(true),  
	
        ]);	 
    }
	
	/**
     * APP reportsview
     */
    public function reportsview(?array $data): void
    {
		$suppliers = (new supplier())->find();
		$equipments = (new equipment())->find();
        if (!empty($data["view"]) && $data["view"] == "reportsview") {
			
			$data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
			
			if (((isset($data["supplier_id"])) && (isset($data["equipment_id"])) && (isset($data["date_at"]))) && (($data["supplier_id"]!="") || ($data["equipment_id"]!="") || ($data["date_at"]!=""))){
					
				if ($data["supplier_id"]) {
					$reservations = new Reservation();
					$supplier_id = $data["supplier_id"];
					$reservations->find("supplier_id= :supplier_id", "supplier_id={$supplier_id}")->fetch(true);

				}
		
				if ($data["date_at"]) {
					$reservations = new Reservation();
					$date_at = $data["date_at"];
					$reservations->find("date_at= :date_at", "date_at={$date_at}")->fetch(true);

				}	

				if ($data["equipment_id"]) {
					$reservations = new Reservation();
					$equipment_id = $data["equipment_id"];
					$reservations->find("equipment_id= :equipment_id", "equipment_id={$equipment_id}")->fetch(true);
					
				}	
			}
							
		} else {
			
			$reservations = (new Reservation())->find();
			
		}
			     	
		$head = $this->seo->render(
            "Categorias",
            "Lista de Categorias",
            url("/blog"),
            theme("/assets/images/share.jpg")
        );

        echo $this->view->render("reportsview", [
            "head" => $head,
            "reservations" => $reservations->order("date_at DESC")->fetch(true),
			"suppliers" => $suppliers->order("name")->fetch(true),
			"equipments" => $equipments->order("name")->fetch(true),
        ]);
			
    }
	
    /**
     * APP reportsview
     */
    public function user(?array $data): void
    {	
		$users = (new User())->find("application_id = :application","application={$this->user->application_id}");	
		$search = null;
        $all = ("all");
		$pager = new Pager(url("/work/user/{$all}/"));
        $pager->pager($users->count(), 10, (!empty($data["page"]) ? $data["page"] : 1));
	    
		//delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
			
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $userDelete = (new User())->findById($data["user_id"]);

            if (!$userDelete) {
				
                $this->message->error("Você tentnou deletar um usuário que não existe")->flash();
                echo json_encode(["redirect" => url("/work/user")]);
                return;
				
            }
            $userDelete->destroy();
            $this->message->success("O usuário foi excluído com sucesso...")->flash();
            echo json_encode(["redirect" => url("/work/user")]);

            return;
        }
		
		$head = $this->seo->render(
			"Lista de Usuários",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );
	
        echo $this->view->render("user", [
            "head" => $head,
			"search" => $search,
            "users" => $users->order("first_name desc")->limit($pager->limit())->offset($pager->offset())->fetch(true),
			"paginator" => $pager->render(),
        ]);
			
    }
	
	/**
     * APP User Add
     */
    public function userAdd(?array $data): void
    {
		//create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $userCreate = new User();
			$userCreate->application_id = $this->user->application_id;
            $userCreate->first_name = $data["first_name"];
            $userCreate->last_name = $data["last_name"];
            $userCreate->email = $data["email"];
            $userCreate->password = $data["password"];
            $userCreate->level = $data["level"];
            $userCreate->genre = $data["genre"];
            $userCreate->datebirth = date_fmt_back($data["datebirth"]);
            $userCreate->document = preg_replace("/[^0-9]/", "", $data["document"]);
            $userCreate->status = $data["status"];

            //upload photo
            if (!empty($_FILES["photo"])) {
                $files = $_FILES["photo"];
                $upload = new Upload();
                $image = $upload->image($files, $userCreate->fullName(), 600);

                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $userCreate->photo = $image;
            }

            if (!$userCreate->save()) {
                $json["message"] = $userCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $json["message"] = $this->message->success("Cadastro Realizado com sucesso!")->render();
            echo json_encode($json);
            return;
        }
		
        $head = $this->seo->render(
           "Meu perfil - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("user-add", [
            "head" => $head,
            "user" => $this->user,
            "photo" => ($this->user->photo() ? image($this->user->photo, 360, 360) :
                theme("/assets/images/avatar.jpg", CONF_VIEW_APP))
        ]);
				
    }
	
	/**
     * APP User Edit
     */
    public function userEdit(?array $data): void
    {
		if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
			list($d, $m, $y) = explode("/", $data["datebirth"]);
			$userUpdate = (new User())->findById($this->user->id);		
			$userUpdate->first_name = $data["first_name"];
            $userUpdate->last_name = $data["last_name"];
            $userUpdate->email = $data["email"];
            $userUpdate->password = (!empty($data["password"]) ? $data["password"] : $userUpdate->password);
            $userUpdate->level = $data["level"];
            $userUpdate->genre = $data["genre"];
			$userUpdate->datebirth = "{$y}-{$m}-{$d}";		
            $userUpdate->document = preg_replace("/[^0-9]/", "", $data["document"]);
            $userUpdate->status = $data["status"];	
			
			//upload photo
            if (!empty($_FILES["photo"])) {
                if ($userUpdate->photo && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$userUpdate->photo}")) {
                    unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$userUpdate->photo}");
                    (new Thumb())->flush($userUpdate->photo);
                }

                $files = $_FILES["photo"];
                $upload = new Upload();
                $image = $upload->image($files, $userUpdate->fullName(), 600);

                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $userUpdate->photo = $image;
            }
			

		        if (!$userUpdate->save()) {	
					$json["message"] = $userUpdate->message()->render();
					echo json_encode($json);	
					return;
				}

            $json["message"] = $this->message->success("Cadastro Realizado com sucesso!")->render();
            echo json_encode($json);
            return;
        }

        $userEdit = null;
		
        if (!empty($data["id"])) {
            $userId = filter_var($data["id"], FILTER_VALIDATE_INT);
            $userEdit = (new User())->findById($userId);
        }

       $head = $this->seo->render(
		    "Atualizar Usuários",
			CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );
		
        echo $this->view->render("user-edit", [
            "head" => $head,
            "user" => $userEdit

        ]);		  	 
			
    }
	
}