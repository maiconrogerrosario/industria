<!doctype html>
<html>
<head>
    
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <?= $head; ?>

	
	<!-- END: theme main stylesheet files -->
	
<style>
@import url('https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800');

/*APP*/

body {
    /*body vars*/
    --body-bg: #F7FBFC;
    --body-color: #6194A0;

    font-family: 'Open Sans', sans-serif;
    background-color: #F7FBFC;
}

/* FORM */
.app_form label {
    display: block;
    margin-bottom: var(--area-normal);
    cursor: pointer;
}

.app_form .field {
    display: block;
    margin-bottom: 5px;
    font-size: var(--font-small);
    color: #888888;
}

.app_form textarea,
.app_form select,
.app_form input {
    font-size: 1em;
    color: #888888;
    border: 2px solid #cccccc;
    display: block;
    background: none;
    width: 100%;
    padding: 10px;
}

.app_form select {
    cursor: pointer;
}

.app_form textarea {
    resize: vertical;
}

.app_form input[type="date"] {
    -webkit-appearance: none;
    font-size: 1em !important;
    font-family: "Open Sans", serif !important;
    padding: 7px 10px !important;
    font-weight: var(--font-normal);
    color: #888888;
}

.app_form select {
    -webkit-appearance: none;
    -moz-appearance: none;
}


.app_form .label_group {
    display: flex;
    width: 100%;
}

.app_form .label_group label {
    flex-basis: calc(50% - var(--area-small));
}

.app_form .label_group label:first-child {
    margin-right: var(--area-normal);
}

.app_form .label_check label {
    display: inline-block;
    margin-left: var(--area-normal);
    font-size: var(--font-small);
    margin-top: 5px;
    color: #888888;
}

.app_form .label_check label input {
    display: none;
}

.app_form .label_check label:before {
    content: "✓";
    font-weight: var(--weight-black);
    color: #ffffff;
    text-align: center;

    display: inline-block;
    width: 12px;
    height: 12px;
    padding: 2px;
    background: #ffffff;
    border: 2px solid #cccccc;

    margin-right: 5px;
    vertical-align: middle;
    margin-top: -3px;

    font-size: 1.1em;
    line-height: 0.9;

    -webkit-border-radius: var(--radius-normal);
    -moz-border-radius: var(--radius-normal);
    border-radius: var(--radius-normal);
}

.app_form .label_check label.check:before {
    background: var(--color-green);
    border-color: var(--color-green);
}

.app_form .label_check label:first-of-type {
    margin-left: 0;
}

.app_form .btn {
    display: block;
    width: 100%;
    padding: 15px;
    border: none;
    cursor: pointer;
    background: var(--color-green);
    margin-top: var(--area-small);

    color: #ffffff;
    font-size: var(--font-normal);
    text-transform: uppercase;
    font-weight: var(--weight-black);
}

.app_form .btn:hover {
    background: var(--hover-color-green);
}

.app_form .btn_inline {
    display: inline-block;
    width: auto;
    padding: 15px 30px;
    margin: 0 var(--area-small);
}

.btn_back,
.btn_remove {
    cursor: pointer;
    font-weight: bold;
    color: var(--color-red);
    opacity: 0.5;
    text-decoration: none;
}

.btn_back:hover,
.btn_remove:hover {
    opacity: 1;
}

.btn_back {
    color: var(--color-blue);
}


.app_form .filter {
    display: block;
    border: none;
    padding: 0 10px;
    font-size: var(--font-normal);
    color: #ffffff;
    cursor: pointer;
    background: var(--color-green);
}

.app_form .filter:hover {
    background-color: var(--hover-color-green);
}

.app_form .filter.expense {
    background: var(--color-red);
}

.app_form .filter.expense:hover {
    background-color: var(--hover-color-red);
}

.app_invoice_link a {
    color: var(--body-color);
    text-decoration: none;
    font-weight: var(--weight-bold);
}

.app_invoice_link a:hover {
    text-decoration: underline;
}

/*MODAL EXPENSE VARIATION*/
.app_modal_expense form .label_check label.check:before {
    background: var(--color-red);
    border-color: var(--color-red);
}

.app_modal_expense form .btn {
    background: var(--color-red);
}

.app_modal_expense form .btn:hover {
    background: var(--hover-color-red);
}

/*APP CONTAINER*/
.app {
    /*app vars*/
    --area-small: 10px;
    --area-normal: calc(var(--area-small) * 2);
    --area-box: calc(var(--area-small) * 3);

    width: 90%;
    max-width: 1200px;
    padding: 5% 0;
    margin: 0 auto;
}

/*APP HEADER*/
.app_header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    margin-bottom: var(--area-box);
}

.app_header h1 {
    color: #888888;
    font-size: var(--font-large);
    font-weight: var(--weight-bold);
}

.app_header h1 a {
    color: #888888;
    text-decoration: none;
}

.app_header a:hover {
    color: var(--color-green);
}

.app_header_widget {
    display: flex;
    font-size: var(--font-small);
    text-align: center;
}

.app_header_widget li {
    padding: var(--area-small) var(--area-normal);
    cursor: pointer;
    color: var(--color-green);
    font-weight: var(--weight-bold);
    background: rgba(0, 0, 0, 0.03);
}

.app_header_widget li:hover {
    background: var(--gradient-green);
    background-size: 200% auto;
    color: #ffffff;
}

.app_header_widget .wallet {
    position: relative;
    width: 200px;
    max-width: 100%;
}

.app_header_widget .wallet ul {
    left: 0;
    top: 100%;
    width: 100%;
    display: none;
    position: absolute;
    z-index: var(--index-menu);
    padding: 0 10px 10px 10px;
    background: #F7FBFC;
    border-radius: 0 0 4px 4px;
}

.app_header_widget .wallet ul li {
    margin-top: 10px;
}


.app_header_widget_mobile {
    margin-left: var(--area-normal);
    display: none;
}

/*APP FOOTER*/
.app_footer {
    text-align: center;
    margin-top: var(--area-box);
    font-size: var(--font-small);
    color: var(--color-default);
}

/*APP BOX*/
.app_box {
    display: flex;
    align-items: flex-start;
}

.rounded {
    -webkit-border-radius: var(--radius-round);
    -moz-border-radius: var(--radius-round);
    border-radius: var(--radius-round);
}

/*APP SIDEBAR*/
.app_sidebar {
    flex-basis: 20%;
    background: #ffffff;
    padding: var(--area-normal);
}

.app_sidebar_widget_mobile {
    display: none;
    padding: var(--area-small) 0;
    background: #fbfbfb;
    text-align: center;
    font-size: calc(var(--font-normal) * 2);
    margin-bottom: var(--area-box);
    cursor: pointer;
    color: var(--color-default);
}

.app_sidebar_widget_mobile:hover {
    color: #ffffff;
    background: var(--color-red);
}

.app_sidebar_user {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: var(--font-small);
}

.app_sidebar_user .user {
    display: flex;
    align-items: center;
}

.app_sidebar_user .user img {
    width: 18%;
    margin-right: var(--area-small);
    padding: 2px;
    background-color: var(--color-green);
}

.app_sidebar_user .plan {
    padding: 2px 6px;
    background: var(--color-green);
    color: #ffffff;
    font-weight: bold;
    font-size: var(--font-small);
}

/*nav*/
.app_sidebar_nav span,
.app_sidebar_nav a {
    display: block;
    padding: var(--area-small) var(--area-normal);
    background: var(--body-bg);
    margin-bottom: var(--area-small);
    font-size: var(--font-small);
    color: var(--body-color);
    font-weight: var(--weight-bold);
    text-decoration: none;
    cursor: pointer;
}

.app_sidebar_nav span:hover,
.app_sidebar_nav a:hover,
.app_sidebar_nav a.active {
    background: var(--body-color);
    color: #ffffff;
}

/*APP MAIN*/
.app_main {
    flex-basis: 80%;
    padding-left: var(--area-box);
}

.app_main_box {
    display: flex;
}

.app_main_left {
    flex-basis: 65%;
}

.app_main_left_fature {
    display: flex;
}

.app_main_left_fature .app_widget {
    flex-basis: calc(50% - var(--area-small));
}

.app_main_left_fature .app_widget:first-child {
    margin-right: var(--area-box);
}

.app_main_right {
    flex-basis: 35%;
    margin-left: var(--area-box);
}

/*APP MODAL*/
.app_modal {
    position: fixed;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    padding: var(--area-box) 0;
    background: rgba(97, 148, 160, 0.5);
    z-index: var(--index-modal);
    display: none;
    overflow-y: auto;
}

.app_modal .message {
    text-align: center;
    margin-bottom: var(--area-normal);
}

.app_modal_box {
    display: none;
    margin: auto;
    width: 500px;
    max-width: 94%;
    padding: calc(var(--area-box) * 1.5);
    background: #ffffff;

    -webkit-border-radius: var(--radius-normal);
    -moz-border-radius: var(--radius-normal);
    border-radius: var(--radius-normal);
}

.app_modal_box .title {
    font-size: var(--font-large);
    font-weight: var(--weight-light);
    color: var(--color-default);
    margin-bottom: var(--area-normal);
    padding-bottom: var(--area-normal);
    border-bottom: 1px solid #EEEEEE;
}

.app_modal_box p {
    margin: 0 0 15px 0;
}

/*APP WIDGET*/
.app_widget {
    padding: var(--area-normal);
    background: #ffffff;
    margin-bottom: var(--area-box);

    -webkit-border-radius: var(--radius-normal);
    -moz-border-radius: var(--radius-normal);
    border-radius: var(--radius-normal);

    -webkit-box-shadow: 0 0 4px 0 rgba(0, 0, 0, 0.3);
    -moz-box-shadow: 0 0 4px 0 rgba(0, 0, 0, 0.3);
    box-shadow: 0 0 4px 0 rgba(0, 0, 0, 0.3);
}

.app_widget_title {
    color: #888888;
    border-bottom: 1px solid #cccccc;
    margin-bottom: var(--area-normal);
    padding-bottom: var(--area-small);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.app_widget_title h2 {
    font-size: var(--font-normal);
}

.app_widget_title .action {
    color: #ffffff;
    background: var(--color-green);
    padding: 2px 4px;
    font-size: var(--font-small);
    cursor: pointer;
}

.app_widget_title .action:hover {
    background: var(--hover-color-green);
}

.app_widget_content {
    font-size: var(--font-small);
}

.app_widget_more {
    display: block;
    text-align: center;
    text-transform: uppercase;
    text-decoration: none;
    font-size: var(--font-small);
    color: #888888;
    margin-top: var(--area-normal);
}

.app_widget_more:hover {
    color: #333333;
    cursor: pointer;
}

/*SHORTCUTS*/
.app_widget_shortcuts {
    display: flex-box;
    align-items: stretch;
    justify-content: space-between;
    margin-bottom: var(--area-box);
}

.app_widget_shortcuts li {
    text-align: stretch;
    padding: 10px;
    font-size: var(--font-small);
    border: 1px solid #cccccc;
    flex-basis: calc(50% - var(--area-small));
    cursor: pointer;
}

.app_widget_shortcuts li p {
    margin: 0;
    font-weight: bold;
    text-transform: uppercase;
}

.app_widget_shortcuts .income {
    border-color: var(--color-green);
    color: var(--color-green);
}

.app_widget_shortcuts .income:hover {
    color: #ffffff;
    background-color: var(--color-green);
}

.app_widget_shortcuts .expense {
    border-color: var(--color-red);
    color: var(--color-red);
}

.app_widget_shortcuts .expense:hover {
    color: #ffffff;
    background-color: var(--color-red);
}

/*APP FLEX*/
.app_flex {
    padding: var(--area-box);
    margin-bottom: var(--area-box);
    background-size: 200% auto;
    color: #ffffff;
    text-align: center;

    -webkit-border-radius: var(--radius-normal);
    -moz-border-radius: var(--radius-normal);
    border-radius: var(--radius-normal);

    -webkit-box-shadow: 0 0 4px 0 rgba(0, 0, 0, 0.3);
    -moz-box-shadow: 0 0 4px 0 rgba(0, 0, 0, 0.3);
    box-shadow: 0 0 4px 0 rgba(0, 0, 0, 0.3);
}

.app_flex_title h2 {
    display: inline-block;
    font-size: var(--font-small);
    font-weight: var(--weight-bold);
    padding: 3px 20px;
    background: rgba(0, 0, 0, 0.3);
}

.app_flex_amount {
    margin-top: 5px;
    font-weight: bold;
    font-size: 1.8em;
}

.app_flex_balance {
    font-size: var(--font-small);
    margin: 10px 0 0 0;
}

.app_flex_balance span {
    display: block;
}

/*WIDGET BALANCE*/
.app_widget_balance .balance {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: var(--area-small);
    padding-bottom: var(--area-small);
    border-bottom: 1px solid #EEEEEE;
    color: #777;
}

.app_widget_balance .balance p {
    margin: 0;
    font-size: 1em;
    font-weight: var(--weight-bold);
}

.app_widget_balance .balance .desc {
    padding-left: 10px;
    border-left: 1px dotted #cccccc;
}

.app_widget_balance .balance .price {
    display: flex;
    align-items: center;
}

.app_widget_balance .balance p .date {
    display: block;
    font-size: 0.8em;
    color: #888888;
}

.app_widget_balance .balance .check {
    font-size: 1.4em;
    margin-left: 8px;
    cursor: pointer;
    opacity: 0.5;
}

.app_widget_balance .balance .check:hover,
.app_widget_balance .balance .check.active {
    opacity: 1;
}

.app_widget_balance .balance.positive .check {
    color: var(--color-green);
}

.app_widget_balance .balance.negative .check {
    color: var(--color-red);
}

/*WIDGET BLOG*/
.app_widget_blog_article {
    display: flex;
    align-items: flex-start;
    padding-bottom: var(--area-normal);
    margin-bottom: var(--area-normal);
    border-bottom: 1px solid #EEEEEE;
}

.app_widget_blog_article .thumb {
    flex-basis: 40%;
}

.app_widget_blog_article .title {
    flex-basis: 60%;
    padding-left: var(--area-normal);
    font-size: var(--font-normal);
    font-weight: var(--weight-normal);
}

.app_widget_blog_article a {
    color: var(--body-color);
    text-decoration: none;
}

.app_widget_blog_article a:hover {
    text-decoration: underline;
}

/*LAUNCH*/
.app_launch_btn {
    display: block;
    padding: 8px 16px;
    border: 1px solid #333333;
    cursor: pointer;
    font-weight: var(--weight-bold);
    font-size: var(--font-small);
}

.app_launch_btn:hover {
    background-color: #333333;
    color: #ffffff;
}

.app_launch_btn.income {
    border-color: var(--color-green);
    color: var(--color-green);
}

.app_launch_btn.income:hover {
    background-color: var(--color-green);
    color: #ffffff;
}

.app_launch_btn.expense {
    border-color: var(--color-red);
    color: var(--color-red);
}

.app_launch_btn.expense:hover {
    background-color: var(--color-red);
    color: #ffffff;
}

.app_launch_header {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.app_launch_form_filter {
    display: flex;
    font-size: var(--font-small);
}

.app_launch_form_filter select,
.app_launch_form_filter input {
    margin-right: var(--area-normal);
    padding: 7px;
}

.app_launch_box {
    margin-top: var(--area-box);
}

.app_launch_item {
    display: flex;
    align-items: center;
    padding: 15px 0;
    background: rgba(0, 0, 0, 0.02);
    font-size: var(--font-small);
    color: #888888;
}

.app_launch_item:nth-child(2n+1) {
    background: rgba(0, 0, 0, 0.05);
}

.app_launch_item.header {
    background: none;
    font-size: 0.7em;
    text-transform: uppercase;
    color: #888888;
}

.app_launch_item.footer {
    justify-content: center;
    background: none;
    font-size: var(--font-normal);
    color: #888888;
    font-weight: bold;
}

.app_launch_item p {
    flex: 0 0 17.5%;
    margin: 0;
    padding: 0 20px;
    text-align: center;
}

.app_launch_item.footer p {
    flex-basis: 50%;
}

.app_launch_item p.desc {
    flex-basis: 30%;
    text-align: left;
}

.app_launch_item .price {
    display: flex;
    justify-content: space-around;
    align-items: center;
    flex-wrap: nowrap;
}

.app_launch_item .price .check {
    margin-left: var(--area-small);
    font-size: 1.3em;
    cursor: pointer;
}

.app_launch_item .price .income {
    color: var(--color-green);
}

.app_launch_item .price .expense {
    color: var(--color-red);
}

/*INVOICE*/
.app_formbox {
    padding: var(--area-box);
}

.app_formbox .field {
    margin-bottom: 15px;
}

.app_formbox_actions {
    margin-top: var(--area-normal);
}

.app_formbox_photo {
    display: flex;
    align-items: center;
    margin-bottom: var(--area-box);
}

.app_formbox_photo .thumb {
    width: 120px;
    height: 120px;
    border: 5px solid #CCCCCC;
    background-size: cover;
    background-position: center center;
    background-repeat: no-repeat;
}

.app_formbox_photo div {
    width: calc(100% - 120px);
    padding-left: var(--area-box);
}

/*WALLETS*/
.app_wallets {
    display: flex;
    flex-wrap: wrap;
}

.app_wallets .wallet {
    flex-basis: calc(50% - 10px);
    margin: 0 10px 20px 0;
    background-size: 200%;
    text-align: center;
    padding: 30px;
    color: #ffffff;
    position: relative;
}

.app_wallets .wallet_add p {
    margin: 10px 0 20px 0 !important;
    font-size: var(--font-small);
}

.app_wallets .wallet_add input {
    margin: 0 0 20px 0 !important;
    font-size: var(--font-normal) !important;
    display: inline-block;
    width: 100%;
}

.app_wallets .wallet_add .btn {
    display: inline-block;
    padding: 5px 10px;
    background: rgba(0, 0, 0, 0.4);
    cursor: pointer;
    font-weight: bold;
}

.app_wallets .wallet_add .btn:hover {
    background: rgba(0, 0, 0, 0.7);
}

.app_wallets .wallet_add .form_btn {
    cursor: pointer;
    border: none;
    padding: 10px;
    font-size: var(--font-normal);
    text-transform: uppercase;
    font-weight: bold;
    color: #ffffff;
}

.app_wallets .wallet_remove {
    position: absolute;
    top: 10px;
    right: 15px;
    cursor: pointer;
    font-size: var(--font-medium);
}

.wallet_overlay {
    display: none;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: var(--color-yellow);
}

.wallet_overlay div {
    margin: auto;
    padding: 30px;
}

.wallet_overlay div p {
    font-size: var(--font-small);
    margin: 20px 0 20px 0 !important;
}

.wallet_overlay div .btn {
    background: rgba(0, 0, 0, 0.5);
    display: inline-block;
    padding: 5px 10px;
    font-weight: bold;
    cursor: pointer;
}

.wallet_overlay div .btn:hover {
    background: var(--color-red);
}

.wallet_overlay_close {
    display: block;
    margin-top: 15px;
    font-size: var(--font-small);
    color: rgba(0, 0, 0, 0.3);
    font-weight: bold;
    cursor: pointer;
}

.wallet_overlay_close:hover {
    color: rgba(0, 0, 0, 0.7);
}

.app_wallets .wallet:nth-child(2n+0) {
    margin: 0 0 20px 10px;
}

.app_wallets .wallet h2 {
    font-size: calc(var(--font-large) * 2);
}

.app_wallets .wallet input {
    margin: 0 0 20px 0;
    text-align: center;
    font-size: var(--font-large);
    padding-bottom: 10px;
    border: none;
    border-bottom: 1px dotted rgba(0, 0, 0, 0.4);
    background: none;
    outline: none;
    color: #ffffff;
    font-weight: bold;
}

.app_wallets .wallet p {
    margin: 0;
}

.app_wallets .wallet .wallet_balance {
    font-size: var(--font-large);
    font-weight: var(--weight-bold);
    margin-bottom: 5px;
}

/*SIGNATURE*/
.app_signature {
    overflow: hidden;
    -webkit-box-shadow: 0 0 4px 0 rgba(0, 0, 0, 0.3);
    -moz-box-shadow: 0 0 4px 0 rgba(0, 0, 0, 0.3);
    box-shadow: 0 0 4px 0 rgba(0, 0, 0, 0.3);
}

.app_signature_header {
    padding: 40px;
    text-align: center;
    color: #ffffff;
    text-shadow: 1px 1px rgba(0, 0, 0, 0.2);
}

.app_signature_header h2 {
    font-size: var(--font-large);
    font-weight: var(--weight-black);
}

.app_signature_header p {
    font-weight: var(--weight-bold);
}

.app_signature_header .icon {
    font-size: calc(var(--font-large) * 3);
}

.app_signature_me {
    padding: 40px;
    background: #ffffff;
}

.app_signature_me p {
    margin: 0;
}

.app_signature_me_header {
    text-align: center;
    color: #888888;
    margin: 30px 0;
}

.app_signature_detail {
    padding: 20px;
    background: #FAFAFA;
    margin-bottom: 20px;
    font-size: var(--font-small);
}

.app_signature_detail li {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.app_signature_detail li:nth-child(2n+0) {
    background: #ffffff;
}

.app_signature_detail li span{
    flex-basis: 50%;
    padding: 15px;
    color: #888888;
}

.app_signature_info{
    color: #888888;
    font-size: var(--font-small);
}

.app_signature_orders_item{
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: var(--font-small);
    color: #888888;
    text-align: center;
}

.app_signature_orders_item:nth-child(2n+0){
    background: #FAFAFA;
}

.app_signature_orders_item p{
    padding: 15px;
    flex-basis: 33.33%;
}

.app_signature_resources {
    padding: 40px;
    background: #ffffff;
    text-align: center;
}

.app_signature_resources h3 {
    font-size: var(--font-large);
    margin-bottom: 30px;
    color: #888888;
}

.app_signature_resources p {
    margin: 0;
}

.app_signature_resources_item {
    color: #888888;
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 100%;
}

.app_signature_resources_item.title {
    padding: 20px 0;
    font-weight: bold;
    color: #cccccc;
}

.app_signature_resources_item p {
    padding: 15px;
    flex-basis: 33.33%;
}

.app_signature_resources_item:nth-child(2n+1) {
    background: #FAFAFA;
}

.app_signature_resources_item .icon-check {
    color: var(--color-green);
}

.app_signature_resources_item .icon-error {
    color: var(--color-red);
}


.app_signature_resources_item .resouce {
    font-weight: var(--weight-bold);
}

.app_signature_pay {
    padding: 0 40px 40px 40px;
    background: #ffffff;
}

.app_signature_pay header {
    text-align: center;
    margin-bottom: 20px;
    color: #888888;
}

.app_signature_pay header p {
    margin-top: 5px;
    font-size: var(--font-small)
}

.app_signature_pay_card {
    max-width: 500px;
    margin: 0 auto;
}

.app_signature_pay_card .label_check {
    margin-bottom: 20px;
}




	


</style>
	
	

</head>
<body>
	<div class="app">
   
    <div class="app_box">
      

        <main class="app_main">
          
			
		   
        </main>
    </div>

    <footer class="app_footer">
        <span class="">
            CaféApp - Desenvolvido na formação FSPHP<br>
            UpInside - Todos os direitos reservados
        </span>
    </footer>

   
</div>
	



</body>
</html>
