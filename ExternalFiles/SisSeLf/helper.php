<?php 
ob_start(); 

error_reporting(0); 
date_default_timezone_set('Asia/Tehran');
include 'config.php';
$Sudo = [$admin0, 965194536, 971621004, 1315949751, 00000]; // ایدی عددی ادمین
define('API_KEY', $token); // توکن هلپر
ini_set("log_errors","off");
echo file_get_contents('https://api.telegram.org/bot'.API_KEY.'/setwebhook?url=https://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF']);
function bot($method,$datas=[]){
	$url = "https://api.telegram.org/bot".API_KEY."/".$method;
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
	$res = curl_exec($ch);
	if(curl_error($ch)){
		var_dump(curl_error($ch));
	}else{
		return json_decode($res);
	}
}
function GetMe(){
	return Bot('getMe');
}
$bot = GetMe();
$botid = getMe() -> result -> username; 
$botname = getMe() -> result -> first_name; 
$botusername = getMe() -> result -> username;

$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$chat_id = $message->chat->id;
$message_id = $message->message_id;
$from_id = $message->from->id;
$fromid = $update->callback_query->from->id;
$firstname = $update->callback_query->from->first_name;
$text = $message->text;
$inline = $update->inline_query->query;
$chatsid = $update->callback_query->from->id;$data = $update->callback_query->data;
$inline_message_id = $update->callback_query->inline_message_id;
$re_id = $update->message->reply_to_message->from->id;$rt = $update->message->reply_to_message;
$replyid = $update->message->reply_to_message->message_id;
$edit = $update->edited_message->text;$message_edit_id = $update->edited_message->message_id;
$chat_edit_id = $update->edited_message->chat->id;$edit_for_id = $update->edited_message->from->id;
$membercall = $update->callback_query->id;

if( $text == '/start' ) {
	bot('sendMessage',
	[
		'chat_id' => $chat_id,
		'text' => "All Right",
	]
);
}

if(strpos($inline,'panel') !== false ) {
$inlin = str_replace("panel","",$inline);
bot("answerInlineQuery",[
"inline_query_id"=>$update->inline_query->id,
"results"=>json_encode([[
"type"=>"article",
"id"=>base64_encode(rand(5,555)),
"title"=>"» پنل مدیریت SisSeLf «",
"input_message_content"=>["parse_mode"=>"MarkDown","message_text"=>"» ᴘᴀɴᴇʟ sᴇɴᴅ ғᴏʀ ʏᴏᴜ . . . !"],
"reply_markup"=>["inline_keyboard"=>[
[["text"=>"» ʟᴏᴄᴋ ᴍᴏᴅᴇs «","callback_data"=>"lockmode"],
["text"=>"» ɪɴғᴏ «","callback_data"=>"info"]],

[["text"=>"» ʜᴇʟᴘ «","callback_data"=>"Help"],
["text"=>"» sᴛᴀᴛᴜs «","callback_data"=>"Stats"]],

[["text"=>"» ᴇxɪᴛ «","callback_data"=>"exit"]],]]]])]);}

if($data == "Stats" && in_array($fromid, $Sudo)){
    
$partmode=file_get_contents("../part.txt");
$time = file_get_contents("../time.txt");
$hashtagmode=file_get_contents("../hashtag.txt");
$mentionmode=file_get_contents("../mention.txt");
$boldmode=file_get_contents("../bold.txt");
$italicmode=file_get_contents("../italic.txt");
$underlinemode=file_get_contents("../underline.txt");
$deletedmode=file_get_contents("../deleted.txt");
$mention2mode = file_get_contents("../mention2.txt");
$codingmode = file_get_contents("../coding.txt");
$profname = file_get_contents("../profname.txt");
$reversemode = file_get_contents("../reversemode.txt");
$dataa = json_decode(file_get_contents("../data.json"),true);
$typing = $dataa['typing'];
$game = $dataa['game'];
$voice = $dataa['voice'];
$video = $dataa['video'];
$mem_using = round(memory_get_usage() / 1024 / 1024,1);
$load = sys_getloadavg();

if (strpos(PHP_OS, 'L') !== false or strpos(PHP_OS, 'l') !== false) { $a = file_get_contents("..//proc/meminfo");
 $b = explode('MemTotal:', $a)[1];
 $stats = explode(' kB', $b)[0] / 1024 / 1024;
if ($stats != 0) {$mem_total = $stats . 'GB';
} else { $mem_total = 'No Access';}} else {$mem_total = '!';}
bot("answerCallbackQuery",["callback_query_id"=>$update->callback_query->id,"text"=>"ᴡᴀɪᴛ"]);
bot("editmessagetext", ["text"=>"=-=-=-=-=-=-=-=-=-=-=
» sᴛᴀᴛᴜs ɪs : 
=-=-=-=-=-=-=-=-=-=-=
","inline_message_id"=>$inline_message_id,
'parse_mode'=>"MarkDown",
"reply_markup"=>json_encode([
"inline_keyboard"=>[
[["text"=>"» ᴘᴀʀᴛ ᴍᴏᴅᴇ","callback_data"=>"text"],["text"=>"$partmode","callback_data"=>"text"]],
[["text"=>"» ʙᴏʟᴅ ᴍᴏᴅᴇ","callback_data"=>"text"],["text"=>"$boldmode","callback_data"=>"text"]],
[["text"=>"» ᴛɪᴍᴇ ɴᴀᴍᴇ","callback_data"=>"text"],["text"=>"$time","callback_data"=>"text"]],
[["text"=>"» ɪᴛᴀʟɪᴄ ᴍᴏᴅᴇ","callback_data"=>"text"],["text"=>"$italicmode","callback_data"=>"text"]],
[["text"=>"» ᴄᴏᴅɪɴɢ ᴍᴏᴅᴇ","callback_data"=>"text"],["text"=>"$codingmode","callback_data"=>"text"]],
[["text"=>"» ᴅᴇʟᴇᴛᴇᴅ ᴍᴏᴅᴇ","callback_data"=>"text"],["text"=>"$deletedmode","callback_data"=>"text"]],
[["text"=>"» ʜᴀsʜᴛᴀɢ ᴍᴏᴅᴇ","callback_data"=>"text"],["text"=>"$hashtagmode","callback_data"=>"text"]],
[["text"=>"» ᴍᴇɴᴛɪᴏɴ ᴍᴏᴅᴇ","callback_data"=>"text"],["text"=>"$mentionmode","callback_data"=>"text"]],
[["text"=>"» ᴍᴇɴᴛɪᴏɴ2 ᴍᴏᴅᴇ","callback_data"=>"text"],["text"=>"$mention2mode","callback_data"=>"text"]],
[["text"=>"» ᴜɴᴅᴇʀʟɪɴᴇ ᴍᴏᴅᴇ","callback_data"=>"text"],["text"=>"$underlinemode","callback_data"=>"text"]],
[["text"=>"» ᴘɪɴɢ","callback_data"=>"text"],["text"=>"$load[0]","callback_data"=>"text"]],
[["text"=>"» ᴍᴇᴍᴏʀʏ ᴜsɪɴɢ","callback_data"=>"text"],["text"=>"$mem_using","callback_data"=>"text"]],
[["text" => "» ʙᴀᴄᴋ «", "callback_data" => "back"]],
]])]);}
if($data == "exit" && in_array($fromid, $Sudo)){
bot("answerCallbackQuery",["callback_query_id"=>$update->callback_query->id,"text"=>"ᴡᴀɪᴛ"]);
bot("editmessagetext", [
"text"=>"» ᴄʟᴏsᴇ ᴛʜᴇ ᴀᴅᴍɪɴ ᴘᴀɴᴇʟ «","inline_message_id"=>$inline_message_id,
'parse_mode'=>"html"]);}
if($data == "back" && in_array($fromid, $Sudo)){
bot("answerCallbackQuery",["callback_query_id"=>$update->callback_query->id,"text"=>"ᴡᴀɪᴛ"]);
bot("editmessagetext", [
"text"=>"• SisSeLf Helper •","inline_message_id"=>$inline_message_id,
'parse_mode'=>"html",
"reply_markup"=>json_encode([
"inline_keyboard"=>[
"reply_markup"=>["inline_keyboard"=>[
[["text"=>"» ʟᴏᴄᴋ ᴍᴏᴅᴇs «","callback_data"=>"lockmode"],
["text"=>"» ɪɴғᴏ «","callback_data"=>"info"]],

[["text"=>"» ʜᴇʟᴘ «","callback_data"=>"Help"],
["text"=>"» sᴛᴀᴛᴜs «","callback_data"=>"Stats"]],

[["text"=>"» ᴇxɪᴛ «","callback_data"=>"exit"]],]]]])]);}
if($data == "text" && in_array($fromid, $Sudo)){bot('answercallbackquery', ['callback_query_id' =>$membercall,
'text' => "ᴛʜɪs sᴇᴄᴛɪᴏɴ ᴄᴀɴ ɴᴏᴛ ʙᴇ ᴄʜᴀɴɢᴇᴅ\n\nᴄʜᴀɴɴᴇʟ : @SisSeLf\nᴄʀᴇᴀᴛᴏʀ : @SisTan_KinG\nʙᴏᴛ ɴᴀᴍᴇ : $botname
ʙᴏᴛ ᴜsᴇʀɴᴀᴍᴇ : @$botid
",'show_alert' =>true]);}
if($data == "Stats" && in_array($fromid, $Sudo)){
    
$partmode=file_get_contents("../part.txt");
$time = file_get_contents("../time.txt");
$hashtagmode=file_get_contents("../hashtag.txt");
$mentionmode=file_get_contents("../mention.txt");
$boldmode=file_get_contents("../bold.txt");
$italicmode=file_get_contents("../italic.txt");
$underlinemode=file_get_contents("../underline.txt");
$deletedmode=file_get_contents("../deleted.txt");
$mention2mode = file_get_contents("../mention2.txt");
$codingmode = file_get_contents("../coding.txt");
$profname = file_get_contents("../profname.txt");
$reversemode = file_get_contents("../reversemode.txt");
$dataa = json_decode(file_get_contents("../data.json"),true);
$typing = $dataa['typing'];
$game = $dataa['game'];
$voice = $dataa['voice'];
$video = $dataa['video'];
$mem_using = round(memory_get_usage() / 1024 / 1024,1);
$load = sys_getloadavg();

if (strpos(PHP_OS, 'L') !== false or strpos(PHP_OS, 'l') !== false) { $a = file_get_contents("..//proc/meminfo");
 $b = explode('MemTotal:', $a)[1];
 $stats = explode(' kB', $b)[0] / 1024 / 1024;
if ($stats != 0) {$mem_total = $stats . 'GB';
} else { $mem_total = 'No Access';}} else {$mem_total = '!';}
bot("editmessagetext", ["text"=>"=-=-=-=-=-=-=-=-=-=-=
» sᴛᴀᴛᴜs ɪs : 
=-=-=-=-=-=-=-=-=-=-=
","inline_message_id"=>$inline_message_id,
'parse_mode'=>"MarkDown",
"reply_markup"=>json_encode([
"inline_keyboard"=>[
[["text"=>"» ᴘᴀʀᴛ ᴍᴏᴅᴇ","callback_data"=>"text"],["text"=>"$partmode","callback_data"=>"text"]],
[["text"=>"» ʙᴏʟᴅ ᴍᴏᴅᴇ","callback_data"=>"text"],["text"=>"$boldmode","callback_data"=>"text"]],
[["text"=>"» ᴛɪᴍᴇ ɴᴀᴍᴇ","callback_data"=>"text"],["text"=>"$time","callback_data"=>"text"]],
[["text"=>"» ɪᴛᴀʟɪᴄ ᴍᴏᴅᴇ","callback_data"=>"text"],["text"=>"$italicmode","callback_data"=>"text"]],
[["text"=>"» ᴄᴏᴅɪɴɢ ᴍᴏᴅᴇ","callback_data"=>"text"],["text"=>"$codingmode","callback_data"=>"text"]],
[["text"=>"» ᴅᴇʟᴇᴛᴇᴅ ᴍᴏᴅᴇ","callback_data"=>"text"],["text"=>"$deletedmode","callback_data"=>"text"]],
[["text"=>"» ʜᴀsʜᴛᴀɢ ᴍᴏᴅᴇ","callback_data"=>"text"],["text"=>"$hashtagmode","callback_data"=>"text"]],
[["text"=>"» ᴍᴇɴᴛɪᴏɴ ᴍᴏᴅᴇ","callback_data"=>"text"],["text"=>"$mentionmode","callback_data"=>"text"]],
[["text"=>"» ᴍᴇɴᴛɪᴏɴ2 ᴍᴏᴅᴇ","callback_data"=>"text"],["text"=>"$mention2mode","callback_data"=>"text"]],
[["text"=>"» ᴜɴᴅᴇʀʟɪɴᴇ ᴍᴏᴅᴇ","callback_data"=>"text"],["text"=>"$underlinemode","callback_data"=>"text"]],
[["text"=>"» ʀᴇᴠᴇʀsᴇ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$reversemode","callback_data"=>"text"]],
[["text"=>"» ᴘɪɴɢ","callback_data"=>"text"],["text"=>"$load[0]","callback_data"=>"text"]],
[["text"=>"» ᴍᴇᴍᴏʀʏ ᴜsɪɴɢ","callback_data"=>"text"],["text"=>"$mem_using","callback_data"=>"text"]],
[["text" => "» ʙᴀᴄᴋ «", "callback_data" => "back"]],
]])]);}
if($data == "Help" && in_array($fromid, $Sudo)){
bot("answerCallbackQuery",["callback_query_id"=>$update->callback_query->id,"text"=>"ᴡᴀɪᴛ"]);
bot("editmessagetext", [
"text"=>"=-=-=-=-=-=-=-=-=-=-=-=-=-= 
SisSeLf HeLp
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
1 » دریافت راهنمای مدیریتی
=-=-=-=-=-=-=-=-=-=-=-=-=-=
2 » دریافت راهنمای کاربردی
=-=-=-=-=-=-=-=-=-=-=-=-=-=
3 » دریافت راهنمای مود ها
=-=-=-=-=-=-=-=-=-=-=-=-=-=
5 » دریافت راهنمای سرگرمی
=-=-=-=-=-=-=-=-=-=-=-=-=-=
6 » دریافت راهنمای اپدیت ها
=-=-=-=-=-=-=-=-=-=-=-=-=-=
","inline_message_id"=>$inline_message_id,
'parse_mode'=>"MarkDown",
"reply_markup"=>json_encode([
"inline_keyboard"=>[
[["text"=>"❶","callback_data"=>"1"],
["text"=>"❷","callback_data"=>"2"],
["text"=>"❸","callback_data"=>"3"],
["text"=>"❺","callback_data"=>"5"],
["text"=>"➏","callback_data"=>"6"]],
[["text"=>"» ʙᴀᴄᴋ «","callback_data"=>"back"]],]])]);}
if($data == "1" && in_array($fromid, $Sudo)){
bot("answerCallbackQuery",["callback_query_id"=>$update->callback_query->id,"text"=>"ᴡᴀɪᴛ"]);
bot("editmessagetext", [
"text"=>"=-=-=-=-=-=-=-=-=-=-=-=-=-= 
**بـــخـــش مــدیــریــت :**
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `ping `
• *دریافت وضعیت ربات *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `block ` (UserName) یا Rreply) 
• *بلاک کردن شخصی خاص در ربات *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `unblock ` (UserName) یا Rreply) 
• *آزاد کردن شخصی خاص از بلاک در ربات *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `/restart`
• *برای 0 کردن حافظه *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `clean all`
• *پاکسازی تمامی پیام های گروه در صورت ادمین بودن *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `setenemy ` (Reply) or (InPV)
• *افزودن یک کاربر به لییست دشمنان*
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `delenemy ` (Reply) or (InPV)
• *حذف یک کاربر به لیست دشمنان*
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `enemylist`
• *نمایش لیست دشمنان*
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `cleanenemylist`
• *پاکسازی لیست دشمنان*
=-=-=-=-=-=-=-=-=-=-=-=-=-=
 ","inline_message_id"=>$inline_message_id,
'parse_mode'=>"MarkDown",
"reply_markup"=>json_encode(["inline_keyboard"=>[
[["text"=>"❶","callback_data"=>"1"],
["text"=>"❷","callback_data"=>"2"],
["text"=>"❸","callback_data"=>"3"],

["text"=>"❺","callback_data"=>"5"],
["text"=>"➏","callback_data"=>"6"]],
[["text"=>"» ʙᴀᴄᴋ «","callback_data"=>"back"]],]])]);}
if($data == "2" && in_array($fromid, $Sudo)){
bot("answerCallbackQuery",["callback_query_id"=>$update->callback_query->id,"text"=>"ᴡᴀɪᴛ"]);
bot("editmessagetext", [
"text"=>"=-=-=-=-=-=-=-=-=-=-=-=-=-= 
**بـــخـــش کـــاربـــردی :**
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» `/info ` [UserName] یا [UserID] 
• *دریافت اطلاعات کاربر *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `/gpinfo ` 
• *دریافت اطلاعات گروه *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `/flood ` [Count] [Text]
• *ارسال اسپم یک متن به تعداد دلخواه*
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `/save ` [Reply] 
• *سیو کردن پیام و محتوا  در پیوی خود ربات *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `/id ` [reply] 
• *دریافت ایدی عددی کابر *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `!php ` Code 
• *اجرای کد های زبان PHP *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `whois ` Domain 
• *دریافت اطلاعات دامنه مورد نظر *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `scr ` Url 
• *دریافت اسکرین شات از سایت مورد نظر *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `ping ` Url 
• *دریافت پینگ سایت مورد نظر *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `brc ` Url 
• *ساخت QR برای لینک مورد نظر*
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `git ` (username/project) or (Url)
• *دانلود فایل فشرده یک سورس از گیتهاب*
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `user ` UserID
• *منشن کردن یک شخص از طریق آیدی عددی*
=-=-=-=-=-=-=-=-=-=-=-=-=-= 

","inline_message_id"=>$inline_message_id,
'parse_mode'=>"MarkDown",
"reply_markup"=>json_encode(["inline_keyboard"=>[
[["text"=>"❶","callback_data"=>"1"],
["text"=>"❷","callback_data"=>"2"],
["text"=>"❸","callback_data"=>"3"],

["text"=>"❺","callback_data"=>"5"],
["text"=>"➏","callback_data"=>"6"]],
[["text"=>"» ʙᴀᴄᴋ «","callback_data"=>"back"]],]])]);}
if($data == "3" && in_array($fromid, $Sudo)){
bot("answerCallbackQuery",["callback_query_id"=>$update->callback_query->id,"text"=>"ᴡᴀɪᴛ"]);
bot("editmessagetext", [
"text"=>"
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
• **بـــَـــخـــشِ مـــُـــود هـــا : **
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `part ` on یا off 
• *حالت حرف به حرف نوشتن *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `hashtag ` on یا off 
• *حالت نوشتن متن با هشتگ *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `italic ` on یا off 
• *حالت نوشتن متن به صورت کج *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `coding ` on یا off 
• *حالت نوشتن متن به صورت تکی و کدینگ *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `underline ` on یا off 
• *حالت نوشتن متن به صورت زیر خط دار *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `deleted ` on یا off 
• *حالت نوشتن متن به صورت خط خورده *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `bold ` on یا off 
• *حالت نوشتن متن به صورت ضخیم *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `mention ` on یا off 
• *حالت نوشتن متن با منشن کردن روی آیدی اکانت *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `mention2 ` on یا off 
• *حالت نوشتن متن با منشن کردن روی آیدی اکانت فرد ریپلای شده *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `reverse ` on یا off 
• *حالت نوشتن متن به صورت معکوس*
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `time name ` on یا off 
• *حالت ساعت در اسم *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `online ` on یا off 
• *حالت همیشه آنلاین*
=-=-=-=-=-=-=-=-=-=-=-=-=-=","inline_message_id"=>$inline_message_id,
'parse_mode'=>"MarkDown",
"reply_markup"=>json_encode(["inline_keyboard"=>[
[["text"=>"❶","callback_data"=>"1"],
["text"=>"❷","callback_data"=>"2"],
["text"=>"❸","callback_data"=>"3"],

["text"=>"❺","callback_data"=>"5"],
["text"=>"➏","callback_data"=>"6"]],
[["text"=>"» ʙᴀᴄᴋ «","callback_data"=>"back"]],]])]);}
if($data == "5" && in_array($fromid, $Sudo)){
bot("answerCallbackQuery",["callback_query_id"=>$update->callback_query->id,"text"=>"ᴡᴀɪᴛ"]);
bot("editmessagetext", [
"text"=>"=-=-=-=-=-=-=-=-=-=-=-=-=-= 
• **بـــَـــخـــشِ فــــــان : **
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `/music ` [TEXT] 
• *موزیک درخواستی *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `/gif ` [Text] 
• *گیف درخاستی *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `/pic ` [Text] 
• *عکس درخاستی *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `/apk ` [Text] 
• *برنامه درخاستی *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `/like ` [Text] 
• *گذاشتن دکمه شیشه ای لایک زیر متن *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `/upload ` [URL] 
• *اپلود فایل از لینک *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `/meme ` [Text] 
• *ویس درخاستی از ربات پرشین میم *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `/giff ` [Text] 
• *گیف درخاستی با متن دلخواه *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `font ` [Text] 
• *ساخت فونت اسم لاتین شما با 125 مدل مختلف *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `fafont ` [Text] 
• *ساخت فونت اسم فارسی شما با 10 مدل مختلف *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `age ` (Y)(M)(D) 
• *درخاست محاسبه سن شما *
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `arz`
• *دریافت قیمت ارز*
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» `rev ` [Text] 
• *معکوس کردن جمله شما*
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» `meane ` [Text] 
• *دریافت معانی کلمات فارسی*
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» `kalame ` [Level] 
• *دریافت بازی از ربات کلمه*
• (مبتدی|ساده|متوسط|سخت|وحشتناک)
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» `fal` 
• *دریافت فال حافظ*
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `/icon ` [Text] 
• *آیکون با کلمه درخاستی و شکلک رندوم*
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `/lid ` [ID] 
• *برای دریافت لینک آیکون مورد نظر در پیوی خودتان*
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ᴍᴇᴍ ᴜsᴀɢᴇ : **$mem_using** ᴍɢ
=-=-=-=-=-=-=-=-=-=-=-=-=-=
","inline_message_id"=>$inline_message_id,
'parse_mode'=>"MarkDown",
"reply_markup"=>json_encode(["inline_keyboard"=>[
[["text"=>"❶","callback_data"=>"1"],
["text"=>"❷","callback_data"=>"2"],
["text"=>"❸","callback_data"=>"3"],

["text"=>"❺","callback_data"=>"5"],
["text"=>"➏","callback_data"=>"6"]],
[["text"=>"» ʙᴀᴄᴋ «","callback_data"=>"back"]],]])]);}

//===============================================
if($data == "6" && in_array($fromid, $Sudo)){
$mem_using = round(memory_get_usage() / 1024 / 1024,1);
$load = sys_getloadavg();
bot("editmessagetext", [
"text"=>"=-=-=-=-=-=-=-=-=-=-=-=-=-= 
**بخش جدید :**
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `cor` iran 
• *اطلاعات کرونای کشور ها*
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `wh` مشهد 
• *اب و هوای شهر*
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `najva` text + reply
• *ارسال نجوا خصوصی*
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `dl` Reply
• *ذخیره عکس زمان دار*
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `stats` 
• *دریافت امار اکانت*
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `tag` 
• *تگ کردن افراد گروه*
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `silent ` (Reply) or (InPV)
• *افزودن یک کاربر به لییست سکوت*
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `unsilent ` (Reply) or (InPV)
• *حذف یک کاربر به لیست سکوت*
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `silentlist`
• *نمایش لیست سکوت*
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `cleansilentlist`
• *پاکسازی لیست سکوت*
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `/setanswer` (Msg) | (Ans)
• *تنظیم متن و پاسخ متن*
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `delanswer` (Text)
• *حذف یک پاسخ*
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `answerlist`
• *دریافت لیست پاسخ*
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» `cleananswers`
• *پاکسازی لیست پاسخ*
=-=-=-=-=-=-=-=-=-=-=-=-=-= 
» ᴍᴇᴍ ᴜsᴀɢᴇ : **$mem_using** ᴍɢ
=-=-=-=-=-=-=-=-=-=-=-=-=-=
","inline_message_id"=>$inline_message_id,
'parse_mode'=>"MarkDown",
"reply_markup"=>json_encode([
"inline_keyboard"=>[

[["text" => "» ʙᴀᴄᴋ «", "callback_data" => "back"]],
]])]);
}
//===============================================================
if($data == "info" && in_array($fromid, $Sudo)){
$mem_using = round(memory_get_usage() / 1024 / 1024,1);
$load = sys_getloadavg();
bot("editmessagetext", [
"text"=>"
• ᴘɪɴɢ » `$load[0]` «
=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
• ᴍᴇᴍᴏʀʏ » `$mem_using` «
","inline_message_id"=>$inline_message_id,
'parse_mode'=>"MarkDown",
"reply_markup"=>json_encode([
"inline_keyboard"=>[

[["text" => "» ʙᴀᴄᴋ «", "callback_data" => "back"]],
]])]);
}
//==================================================================
if($data == "back" && in_array($fromid, $Sudo)){
bot("answerCallbackQuery",["callback_query_id"=>$update->callback_query->id,"text"=>"ᴡᴀɪᴛ"]);
bot("editmessagetext", [
"text"=>"• SisSeLf Helper •","inline_message_id"=>$inline_message_id,
'parse_mode'=>"html",
"reply_markup"=>json_encode([
"inline_keyboard"=>[
[["text"=>"» ʟᴏᴄᴋ ᴍᴏᴅᴇs «","callback_data"=>"lockmode"],
["text"=>"» ɪɴғᴏ «","callback_data"=>"info"]],


[["text"=>"» ʜᴇʟᴘ «","callback_data"=>"Help"],
["text"=>"» sᴛᴀᴛᴜs «","callback_data"=>"Stats"]],

[["text"=>"» ᴇxɪᴛ «","callback_data"=>"exit"]],]])]);}



//=====================================================
if($data == "lockmode" && in_array($fromid, $Sudo)){
$partmode=file_get_contents("../part.txt");
$time = file_get_contents("../time.txt");
$hashtagmode=file_get_contents("../hashtag.txt");
$mentionmode=file_get_contents("../mention.txt");
$boldmode=file_get_contents("../bold.txt");
$italicmode=file_get_contents("../italic.txt");
$underlinemode=file_get_contents("../underline.txt");
$deletedmode=file_get_contents("../deleted.txt");
$mention2mode = file_get_contents("../mention2.txt");
$codingmode = file_get_contents("../coding.txt");
$profname = file_get_contents("../profname.txt");
$reversemode = file_get_contents("../reversemode.txt");
$mem_using = round(memory_get_usage() / 1024 / 1024,1);
$load = sys_getloadavg();    
bot("editmessagetext", ["text"=>"=-=-=-=-=-=-=-=-=-=-=
» ʏᴏᴜ ᴄᴀɴ ᴏɴ ᴏʀ ᴏғғ ʏᴏᴜʀ ᴍᴏᴅᴇs : 
=-=-=-=-=-=-=-=-=-=-=
","inline_message_id"=>$inline_message_id,
'parse_mode'=>"MarkDown",
"reply_markup"=>json_encode([
"inline_keyboard"=>[
[["text"=>"» ᴘᴀʀᴛ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$partmode","callback_data"=>"partmode"]],

[["text"=>"» ʙᴏʟᴅ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$boldmode","callback_data"=>"boldmode"]],

[["text"=>"» ᴛɪᴍᴇ ɴᴀᴍᴇ","callback_data"=>"text"],
["text"=>"$time","callback_data"=>"time"]],

[["text"=>"» ɪᴛᴀʟɪᴄ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$italicmode","callback_data"=>"italicmode"]],

[["text"=>"» ᴄᴏᴅɪɴɢ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$codingmode","callback_data"=>"codingmode"]],

[["text"=>"» ᴅᴇʟᴇᴛᴇᴅ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$deletedmode","callback_data"=>"deletedmode"]],

[["text"=>"» ʜᴀsʜᴛᴀɢ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$hashtagmode","callback_data"=>"hashtagmode"]],

[["text"=>"» ᴍᴇɴᴛɪᴏɴ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$mentionmode","callback_data"=>"mentionmode"]],

[["text"=>"» ᴍᴇɴᴛɪᴏɴ2 ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$mention2mode","callback_data"=>"mention2mode"]],

[["text"=>"» ᴜɴᴅᴇʀʟɪɴᴇ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$underlinemode","callback_data"=>"underlinemode"]],

[["text"=>"» ʀᴇᴠᴇʀsᴇ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$reversemode","callback_data"=>"reversemode"]],


[["text"=>"» =-=-=-=-=-=-=-=-=-=-=-=-=-= «","callback_data"=>"text"],
],

[["text"=>"» ᴘɪɴɢ","callback_data"=>"text"],
["text"=>"$load[0]","callback_data"=>"text"]],

[["text"=>"» ᴍᴇᴍᴏʀʏ ᴜsɪɴɢ","callback_data"=>"text"],
["text"=>"$mem_using","callback_data"=>"text"]],

[["text" => "» ʙᴀᴄᴋ «", "callback_data" => "back"]],
]])]);
}   
//==========================================================
if($data == "partmode" && in_array($fromid, $Sudo)){
$partmode=file_get_contents("../part.txt");
$time = file_get_contents("../time.txt");
$hashtagmode=file_get_contents("../hashtag.txt");
$mentionmode=file_get_contents("../mention.txt");
$boldmode=file_get_contents("../bold.txt");
$italicmode=file_get_contents("../italic.txt");
$underlinemode=file_get_contents("../underline.txt");
$deletedmode=file_get_contents("../deleted.txt");
$mention2mode = file_get_contents("../mention2.txt");
$codingmode = file_get_contents("../coding.txt");
$profname = file_get_contents("../profname.txt");
$reversemode = file_get_contents("../reversemode.txt");
$mem_using = round(memory_get_usage() / 1024 / 1024,1);
$load = sys_getloadavg();    
if ($partmode == "on"){
file_put_contents('../part.txt','off');
$partmode=file_get_contents("../part.txt");
}else{
    file_put_contents('../part.txt','on');
    $partmode=file_get_contents("../part.txt");
}
bot("editMessageReplyMarkup", ["text"=>"=-=-=-=-=-=-=-=-=-=-=
» ʏᴏᴜ ᴄᴀɴ ᴏɴ ᴏʀ ᴏғғ ʏᴏᴜʀ ᴍᴏᴅᴇs : 
=-=-=-=-=-=-=-=-=-=-=
","inline_message_id"=>$inline_message_id,
'parse_mode'=>"MarkDown",
"reply_markup"=>json_encode([
"inline_keyboard"=>[
[["text"=>"» ᴘᴀʀᴛ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$partmode","callback_data"=>"partmode"]],

[["text"=>"» ʙᴏʟᴅ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$boldmode","callback_data"=>"boldmode"]],

[["text"=>"» ᴛɪᴍᴇ ɴᴀᴍᴇ","callback_data"=>"text"],
["text"=>"$time","callback_data"=>"time"]],

[["text"=>"» ɪᴛᴀʟɪᴄ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$italicmode","callback_data"=>"italicmode"]],

[["text"=>"» ᴄᴏᴅɪɴɢ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$codingmode","callback_data"=>"codingmode"]],

[["text"=>"» ᴅᴇʟᴇᴛᴇᴅ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$deletedmode","callback_data"=>"deletedmode"]],

[["text"=>"» ʜᴀsʜᴛᴀɢ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$hashtagmode","callback_data"=>"hashtagmode"]],

[["text"=>"» ᴍᴇɴᴛɪᴏɴ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$mentionmode","callback_data"=>"mentionmode"]],

[["text"=>"» ᴍᴇɴᴛɪᴏɴ2 ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$mention2mode","callback_data"=>"mention2mode"]],

[["text"=>"» ᴜɴᴅᴇʀʟɪɴᴇ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$underlinemode","callback_data"=>"underlinemode"]],

[["text"=>"» ʀᴇᴠᴇʀsᴇ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$reversemode","callback_data"=>"reversemode"]],


[["text"=>"» =-=-=-=-=-=-=-=-=-=-=-=-=-= «","callback_data"=>"text"],
],

[["text"=>"» ᴘɪɴɢ","callback_data"=>"text"],
["text"=>"$load[0]","callback_data"=>"text"]],

[["text"=>"» ᴍᴇᴍᴏʀʏ ᴜsɪɴɢ","callback_data"=>"text"],
["text"=>"$mem_using","callback_data"=>"text"]],

[["text" => "» ʙᴀᴄᴋ «", "callback_data" => "back"]],
]])]);
}   
//=======================================================================
if($data == "time" && in_array($fromid, $Sudo)){
$partmode=file_get_contents("../part.txt");
$time = file_get_contents("../time.txt");
$hashtagmode=file_get_contents("../hashtag.txt");
$mentionmode=file_get_contents("../mention.txt");
$boldmode=file_get_contents("../bold.txt");
$italicmode=file_get_contents("../italic.txt");
$underlinemode=file_get_contents("../underline.txt");
$deletedmode=file_get_contents("../deleted.txt");
$mention2mode = file_get_contents("../mention2.txt");
$codingmode = file_get_contents("../coding.txt");
$profname = file_get_contents("../profname.txt");
$reversemode = file_get_contents("../reversemode.txt");
$mem_using = round(memory_get_usage() / 1024 / 1024,1);
$load = sys_getloadavg();    
if ($time == "on"){
file_put_contents('../time.txt','off');
$time=file_get_contents("../time.txt");
}else{
    file_put_contents('../time.txt','on');
    $time=file_get_contents("../time.txt");
}
bot("editMessageReplyMarkup", ["text"=>"=-=-=-=-=-=-=-=-=-=-=
» ʏᴏᴜ ᴄᴀɴ ᴏɴ ᴏʀ ᴏғғ ʏᴏᴜʀ ᴍᴏᴅᴇs : 
=-=-=-=-=-=-=-=-=-=-=
","inline_message_id"=>$inline_message_id,
'parse_mode'=>"MarkDown",
"reply_markup"=>json_encode([
"inline_keyboard"=>[
[["text"=>"» ᴘᴀʀᴛ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$partmode","callback_data"=>"partmode"]],

[["text"=>"» ʙᴏʟᴅ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$boldmode","callback_data"=>"boldmode"]],

[["text"=>"» ᴛɪᴍᴇ ɴᴀᴍᴇ","callback_data"=>"text"],
["text"=>"$time","callback_data"=>"time"]],

[["text"=>"» ɪᴛᴀʟɪᴄ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$italicmode","callback_data"=>"italicmode"]],

[["text"=>"» ᴄᴏᴅɪɴɢ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$codingmode","callback_data"=>"codingmode"]],

[["text"=>"» ᴅᴇʟᴇᴛᴇᴅ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$deletedmode","callback_data"=>"deletedmode"]],

[["text"=>"» ʜᴀsʜᴛᴀɢ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$hashtagmode","callback_data"=>"hashtagmode"]],

[["text"=>"» ᴍᴇɴᴛɪᴏɴ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$mentionmode","callback_data"=>"mentionmode"]],

[["text"=>"» ᴍᴇɴᴛɪᴏɴ2 ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$mention2mode","callback_data"=>"mention2mode"]],

[["text"=>"» ᴜɴᴅᴇʀʟɪɴᴇ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$underlinemode","callback_data"=>"underlinemode"]],

[["text"=>"» ʀᴇᴠᴇʀsᴇ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$reversemode","callback_data"=>"reversemode"]],


[["text"=>"» =-=-=-=-=-=-=-=-=-=-=-=-=-= «","callback_data"=>"text"],
],

[["text"=>"» ᴘɪɴɢ","callback_data"=>"text"],
["text"=>"$load[0]","callback_data"=>"text"]],

[["text"=>"» ᴍᴇᴍᴏʀʏ ᴜsɪɴɢ","callback_data"=>"text"],
["text"=>"$mem_using","callback_data"=>"text"]],

[["text" => "» ʙᴀᴄᴋ «", "callback_data" => "back"]],
]])]);
}   
//=======================================================================
if($data == "hashtagmode" && in_array($fromid, $Sudo)){
$partmode=file_get_contents("../part.txt");
$time = file_get_contents("../time.txt");
$hashtagmode=file_get_contents("../hashtag.txt");
$mentionmode=file_get_contents("../mention.txt");
$boldmode=file_get_contents("../bold.txt");
$italicmode=file_get_contents("../italic.txt");
$underlinemode=file_get_contents("../underline.txt");
$deletedmode=file_get_contents("../deleted.txt");
$mention2mode = file_get_contents("../mention2.txt");
$codingmode = file_get_contents("../coding.txt");
$profname = file_get_contents("../profname.txt");
$reversemode = file_get_contents("../reversemode.txt");
$mem_using = round(memory_get_usage() / 1024 / 1024,1);
$load = sys_getloadavg();    
if ($hashtagmode == "on"){
file_put_contents('../hashtag.txt','off');
$hashtagmode=file_get_contents("../hashtag.txt");
}else{
    file_put_contents('../hashtag.txt','on');
    $hashtagmode=file_get_contents("../hashtag.txt");
}
bot("editMessageReplyMarkup", ["text"=>"=-=-=-=-=-=-=-=-=-=-=
» ʏᴏᴜ ᴄᴀɴ ᴏɴ ᴏʀ ᴏғғ ʏᴏᴜʀ ᴍᴏᴅᴇs : 
=-=-=-=-=-=-=-=-=-=-=
","inline_message_id"=>$inline_message_id,
'parse_mode'=>"MarkDown",
"reply_markup"=>json_encode([
"inline_keyboard"=>[
[["text"=>"» ᴘᴀʀᴛ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$partmode","callback_data"=>"partmode"]],

[["text"=>"» ʙᴏʟᴅ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$boldmode","callback_data"=>"boldmode"]],

[["text"=>"» ᴛɪᴍᴇ ɴᴀᴍᴇ","callback_data"=>"text"],
["text"=>"$time","callback_data"=>"time"]],

[["text"=>"» ɪᴛᴀʟɪᴄ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$italicmode","callback_data"=>"italicmode"]],

[["text"=>"» ᴄᴏᴅɪɴɢ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$codingmode","callback_data"=>"codingmode"]],

[["text"=>"» ᴅᴇʟᴇᴛᴇᴅ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$deletedmode","callback_data"=>"deletedmode"]],

[["text"=>"» ʜᴀsʜᴛᴀɢ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$hashtagmode","callback_data"=>"hashtagmode"]],

[["text"=>"» ᴍᴇɴᴛɪᴏɴ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$mentionmode","callback_data"=>"mentionmode"]],

[["text"=>"» ᴍᴇɴᴛɪᴏɴ2 ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$mention2mode","callback_data"=>"mention2mode"]],

[["text"=>"» ᴜɴᴅᴇʀʟɪɴᴇ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$underlinemode","callback_data"=>"underlinemode"]],

[["text"=>"» ʀᴇᴠᴇʀsᴇ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$reversemode","callback_data"=>"reversemode"]],


[["text"=>"» =-=-=-=-=-=-=-=-=-=-=-=-=-= «","callback_data"=>"text"],
],
[["text"=>"» ᴘɪɴɢ","callback_data"=>"text"],
["text"=>"$load[0]","callback_data"=>"text"]],

[["text"=>"» ᴍᴇᴍᴏʀʏ ᴜsɪɴɢ","callback_data"=>"text"],
["text"=>"$mem_using","callback_data"=>"text"]],

[["text" => "» ʙᴀᴄᴋ «", "callback_data" => "back"]],
]])]);
}   
//=======================================================================
if($data == "mentionmode" && in_array($fromid, $Sudo)){
$partmode=file_get_contents("../part.txt");
$time = file_get_contents("../time.txt");
$hashtagmode=file_get_contents("../hashtag.txt");
$mentionmode=file_get_contents("../mention.txt");
$boldmode=file_get_contents("../bold.txt");
$italicmode=file_get_contents("../italic.txt");
$underlinemode=file_get_contents("../underline.txt");
$deletedmode=file_get_contents("../deleted.txt");
$mention2mode = file_get_contents("../mention2.txt");
$codingmode = file_get_contents("../coding.txt");
$profname = file_get_contents("../profname.txt");
$reversemode = file_get_contents("../reversemode.txt");
$mem_using = round(memory_get_usage() / 1024 / 1024,1);
$load = sys_getloadavg();    
if ($mentionmode == "on"){
file_put_contents('../mention.txt','off');
$mentionmode=file_get_contents("../mention.txt");
}else{
    file_put_contents('../mention.txt','on');
    $mentionmode=file_get_contents("../mention.txt");
}
bot("editMessageReplyMarkup", ["text"=>"=-=-=-=-=-=-=-=-=-=-=
» ʏᴏᴜ ᴄᴀɴ ᴏɴ ᴏʀ ᴏғғ ʏᴏᴜʀ ᴍᴏᴅᴇs : 
=-=-=-=-=-=-=-=-=-=-=
","inline_message_id"=>$inline_message_id,
'parse_mode'=>"MarkDown",
"reply_markup"=>json_encode([
"inline_keyboard"=>[
[["text"=>"» ᴘᴀʀᴛ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$partmode","callback_data"=>"partmode"]],

[["text"=>"» ʙᴏʟᴅ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$boldmode","callback_data"=>"boldmode"]],

[["text"=>"» ᴛɪᴍᴇ ɴᴀᴍᴇ","callback_data"=>"text"],
["text"=>"$time","callback_data"=>"time"]],

[["text"=>"» ɪᴛᴀʟɪᴄ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$italicmode","callback_data"=>"italicmode"]],

[["text"=>"» ᴄᴏᴅɪɴɢ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$codingmode","callback_data"=>"codingmode"]],

[["text"=>"» ᴅᴇʟᴇᴛᴇᴅ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$deletedmode","callback_data"=>"deletedmode"]],

[["text"=>"» ʜᴀsʜᴛᴀɢ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$hashtagmode","callback_data"=>"hashtagmode"]],

[["text"=>"» ᴍᴇɴᴛɪᴏɴ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$mentionmode","callback_data"=>"mentionmode"]],

[["text"=>"» ᴍᴇɴᴛɪᴏɴ2 ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$mention2mode","callback_data"=>"mention2mode"]],

[["text"=>"» ᴜɴᴅᴇʀʟɪɴᴇ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$underlinemode","callback_data"=>"underlinemode"]],

[["text"=>"» ʀᴇᴠᴇʀsᴇ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$reversemode","callback_data"=>"reversemode"]],

[["text"=>"» =-=-=-=-=-=-=-=-=-=-=-=-=-= «","callback_data"=>"text"],
],

[["text"=>"» ᴘɪɴɢ","callback_data"=>"text"],
["text"=>"$load[0]","callback_data"=>"text"]],

[["text"=>"» ᴍᴇᴍᴏʀʏ ᴜsɪɴɢ","callback_data"=>"text"],
["text"=>"$mem_using","callback_data"=>"text"]],

[["text" => "» ʙᴀᴄᴋ «", "callback_data" => "back"]],
]])]);
}   
//=======================================================================
if($data == "boldmode" && in_array($fromid, $Sudo)){
$partmode=file_get_contents("../part.txt");
$time = file_get_contents("../time.txt");
$hashtagmode=file_get_contents("../hashtag.txt");
$mentionmode=file_get_contents("../mention.txt");
$boldmode=file_get_contents("../bold.txt");
$italicmode=file_get_contents("../italic.txt");
$underlinemode=file_get_contents("../underline.txt");
$deletedmode=file_get_contents("../deleted.txt");
$mention2mode = file_get_contents("../mention2.txt");
$codingmode = file_get_contents("../coding.txt");
$profname = file_get_contents("../profname.txt");
$reversemode = file_get_contents("../reversemode.txt");
$mem_using = round(memory_get_usage() / 1024 / 1024,1);
$load = sys_getloadavg();    
if ($boldmode == "on"){
file_put_contents('../bold.txt','off');
$boldmode=file_get_contents("../bold.txt");
}else{
    file_put_contents('../bold.txt','on');
    $boldmode=file_get_contents("../bold.txt");
}
bot("editMessageReplyMarkup", ["text"=>"=-=-=-=-=-=-=-=-=-=-=
» ʏᴏᴜ ᴄᴀɴ ᴏɴ ᴏʀ ᴏғғ ʏᴏᴜʀ ᴍᴏᴅᴇs : 
=-=-=-=-=-=-=-=-=-=-=
","inline_message_id"=>$inline_message_id,
'parse_mode'=>"MarkDown",
"reply_markup"=>json_encode([
"inline_keyboard"=>[
[["text"=>"» ᴘᴀʀᴛ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$partmode","callback_data"=>"partmode"]],

[["text"=>"» ʙᴏʟᴅ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$boldmode","callback_data"=>"boldmode"]],

[["text"=>"» ᴛɪᴍᴇ ɴᴀᴍᴇ","callback_data"=>"text"],
["text"=>"$time","callback_data"=>"time"]],

[["text"=>"» ɪᴛᴀʟɪᴄ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$italicmode","callback_data"=>"italicmode"]],

[["text"=>"» ᴄᴏᴅɪɴɢ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$codingmode","callback_data"=>"codingmode"]],

[["text"=>"» ᴅᴇʟᴇᴛᴇᴅ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$deletedmode","callback_data"=>"deletedmode"]],

[["text"=>"» ʜᴀsʜᴛᴀɢ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$hashtagmode","callback_data"=>"hashtagmode"]],

[["text"=>"» ᴍᴇɴᴛɪᴏɴ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$mentionmode","callback_data"=>"mentionmode"]],

[["text"=>"» ᴍᴇɴᴛɪᴏɴ2 ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$mention2mode","callback_data"=>"mention2mode"]],

[["text"=>"» ᴜɴᴅᴇʀʟɪɴᴇ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$underlinemode","callback_data"=>"underlinemode"]],

[["text"=>"» ʀᴇᴠᴇʀsᴇ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$reversemode","callback_data"=>"reversemode"]],

[["text"=>"» =-=-=-=-=-=-=-=-=-=-=-=-=-= «","callback_data"=>"text"],
],

[["text"=>"» ᴘɪɴɢ","callback_data"=>"text"],
["text"=>"$load[0]","callback_data"=>"text"]],

[["text"=>"» ᴍᴇᴍᴏʀʏ ᴜsɪɴɢ","callback_data"=>"text"],
["text"=>"$mem_using","callback_data"=>"text"]],

[["text" => "» ʙᴀᴄᴋ «", "callback_data" => "back"]],
]])]);
} 
//=======================================================================
if($data == "italicmode" && in_array($fromid, $Sudo)){
$partmode=file_get_contents("../part.txt");
$time = file_get_contents("../time.txt");
$hashtagmode=file_get_contents("../hashtag.txt");
$mentionmode=file_get_contents("../mention.txt");
$boldmode=file_get_contents("../bold.txt");
$italicmode=file_get_contents("../italic.txt");
$underlinemode=file_get_contents("../underline.txt");
$deletedmode=file_get_contents("../deleted.txt");
$mention2mode = file_get_contents("../mention2.txt");
$codingmode = file_get_contents("../coding.txt");
$profname = file_get_contents("../profname.txt");
$reversemode = file_get_contents("../reversemode.txt");
$mem_using = round(memory_get_usage() / 1024 / 1024,1);
$load = sys_getloadavg();    
if ($italicmode == "on"){
file_put_contents('../italic.txt','off');
$italicmode=file_get_contents("../italic.txt");
}else{
    file_put_contents('../italic.txt','on');
    $italicmode=file_get_contents("../italic.txt");
}
bot("editMessageReplyMarkup", ["text"=>"=-=-=-=-=-=-=-=-=-=-=
» ʏᴏᴜ ᴄᴀɴ ᴏɴ ᴏʀ ᴏғғ ʏᴏᴜʀ ᴍᴏᴅᴇs : 
=-=-=-=-=-=-=-=-=-=-=
","inline_message_id"=>$inline_message_id,
'parse_mode'=>"MarkDown",
"reply_markup"=>json_encode([
"inline_keyboard"=>[
[["text"=>"» ᴘᴀʀᴛ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$partmode","callback_data"=>"partmode"]],

[["text"=>"» ʙᴏʟᴅ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$boldmode","callback_data"=>"boldmode"]],

[["text"=>"» ᴛɪᴍᴇ ɴᴀᴍᴇ","callback_data"=>"text"],
["text"=>"$time","callback_data"=>"time"]],

[["text"=>"» ɪᴛᴀʟɪᴄ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$italicmode","callback_data"=>"italicmode"]],

[["text"=>"» ᴄᴏᴅɪɴɢ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$codingmode","callback_data"=>"codingmode"]],

[["text"=>"» ᴅᴇʟᴇᴛᴇᴅ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$deletedmode","callback_data"=>"deletedmode"]],

[["text"=>"» ʜᴀsʜᴛᴀɢ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$hashtagmode","callback_data"=>"hashtagmode"]],

[["text"=>"» ᴍᴇɴᴛɪᴏɴ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$mentionmode","callback_data"=>"mentionmode"]],

[["text"=>"» ᴍᴇɴᴛɪᴏɴ2 ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$mention2mode","callback_data"=>"mention2mode"]],

[["text"=>"» ᴜɴᴅᴇʀʟɪɴᴇ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$underlinemode","callback_data"=>"underlinemode"]],

[["text"=>"» ʀᴇᴠᴇʀsᴇ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$reversemode","callback_data"=>"reversemode"]],

[["text"=>"» =-=-=-=-=-=-=-=-=-=-=-=-=-= «","callback_data"=>"text"],
],

[["text"=>"» ᴘɪɴɢ","callback_data"=>"text"],
["text"=>"$load[0]","callback_data"=>"text"]],

[["text"=>"» ᴍᴇᴍᴏʀʏ ᴜsɪɴɢ","callback_data"=>"text"],
["text"=>"$mem_using","callback_data"=>"text"]],

[["text" => "» ʙᴀᴄᴋ «", "callback_data" => "back"]],
]])]);
} 
//=======================================================================
if($data == "underlinemode" && in_array($fromid, $Sudo)){
$partmode=file_get_contents("../part.txt");
$time = file_get_contents("../time.txt");
$hashtagmode=file_get_contents("../hashtag.txt");
$mentionmode=file_get_contents("../mention.txt");
$boldmode=file_get_contents("../bold.txt");
$italicmode=file_get_contents("../italic.txt");
$underlinemode=file_get_contents("../underline.txt");
$deletedmode=file_get_contents("../deleted.txt");
$mention2mode = file_get_contents("../mention2.txt");
$codingmode = file_get_contents("../coding.txt");
$profname = file_get_contents("../profname.txt");
$reversemode = file_get_contents("../reversemode.txt");
$mem_using = round(memory_get_usage() / 1024 / 1024,1);
$load = sys_getloadavg();    
if ($underlinemode == "on"){
file_put_contents('../underline.txt','off');
$underlinemode=file_get_contents("../underline.txt");
}else{
    file_put_contents('../underline.txt','on');
    $underlinemode=file_get_contents("../underline.txt");
}
bot("editMessageReplyMarkup", ["text"=>"=-=-=-=-=-=-=-=-=-=-=
» ʏᴏᴜ ᴄᴀɴ ᴏɴ ᴏʀ ᴏғғ ʏᴏᴜʀ ᴍᴏᴅᴇs : 
=-=-=-=-=-=-=-=-=-=-=
","inline_message_id"=>$inline_message_id,
'parse_mode'=>"MarkDown",
"reply_markup"=>json_encode([
"inline_keyboard"=>[
[["text"=>"» ᴘᴀʀᴛ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$partmode","callback_data"=>"partmode"]],

[["text"=>"» ʙᴏʟᴅ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$boldmode","callback_data"=>"boldmode"]],

[["text"=>"» ᴛɪᴍᴇ ɴᴀᴍᴇ","callback_data"=>"text"],
["text"=>"$time","callback_data"=>"time"]],

[["text"=>"» ɪᴛᴀʟɪᴄ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$italicmode","callback_data"=>"italicmode"]],

[["text"=>"» ᴄᴏᴅɪɴɢ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$codingmode","callback_data"=>"codingmode"]],

[["text"=>"» ᴅᴇʟᴇᴛᴇᴅ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$deletedmode","callback_data"=>"deletedmode"]],

[["text"=>"» ʜᴀsʜᴛᴀɢ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$hashtagmode","callback_data"=>"hashtagmode"]],

[["text"=>"» ᴍᴇɴᴛɪᴏɴ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$mentionmode","callback_data"=>"mentionmode"]],

[["text"=>"» ᴍᴇɴᴛɪᴏɴ2 ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$mention2mode","callback_data"=>"mention2mode"]],

[["text"=>"» ᴜɴᴅᴇʀʟɪɴᴇ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$underlinemode","callback_data"=>"underlinemode"]],

[["text"=>"» ʀᴇᴠᴇʀsᴇ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$reversemode","callback_data"=>"reversemode"]],

[["text"=>"» =-=-=-=-=-=-=-=-=-=-=-=-=-= «","callback_data"=>"text"],
],

[["text"=>"» ᴘɪɴɢ","callback_data"=>"text"],
["text"=>"$load[0]","callback_data"=>"text"]],

[["text"=>"» ᴍᴇᴍᴏʀʏ ᴜsɪɴɢ","callback_data"=>"text"],
["text"=>"$mem_using","callback_data"=>"text"]],

[["text" => "» ʙᴀᴄᴋ «", "callback_data" => "back"]],
]])]);
} 
//=======================================================================
if($data == "deletedmode" && in_array($fromid, $Sudo)){
$partmode=file_get_contents("../part.txt");
$time = file_get_contents("../time.txt");
$hashtagmode=file_get_contents("../hashtag.txt");
$mentionmode=file_get_contents("../mention.txt");
$boldmode=file_get_contents("../bold.txt");
$italicmode=file_get_contents("../italic.txt");
$underlinemode=file_get_contents("../underline.txt");
$deletedmode=file_get_contents("../deleted.txt");
$mention2mode = file_get_contents("../mention2.txt");
$codingmode = file_get_contents("../coding.txt");
$profname = file_get_contents("../profname.txt");
$reversemode = file_get_contents("../reversemode.txt");
$mem_using = round(memory_get_usage() / 1024 / 1024,1);
$load = sys_getloadavg();    
if ($deletedmode == "on"){
file_put_contents('../deleted.txt','off');
$deletedmode=file_get_contents("../deleted.txt");
}else{
    file_put_contents('../deleted.txt','on');
    $deletedmode=file_get_contents("../deleted.txt");
}
bot("editMessageReplyMarkup", ["text"=>"=-=-=-=-=-=-=-=-=-=-=
» ʏᴏᴜ ᴄᴀɴ ᴏɴ ᴏʀ ᴏғғ ʏᴏᴜʀ ᴍᴏᴅᴇs : 
=-=-=-=-=-=-=-=-=-=-=
","inline_message_id"=>$inline_message_id,
'parse_mode'=>"MarkDown",
"reply_markup"=>json_encode([
"inline_keyboard"=>[
[["text"=>"» ᴘᴀʀᴛ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$partmode","callback_data"=>"partmode"]],

[["text"=>"» ʙᴏʟᴅ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$boldmode","callback_data"=>"boldmode"]],

[["text"=>"» ᴛɪᴍᴇ ɴᴀᴍᴇ","callback_data"=>"text"],
["text"=>"$time","callback_data"=>"time"]],

[["text"=>"» ɪᴛᴀʟɪᴄ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$italicmode","callback_data"=>"italicmode"]],

[["text"=>"» ᴄᴏᴅɪɴɢ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$codingmode","callback_data"=>"codingmode"]],

[["text"=>"» ᴅᴇʟᴇᴛᴇᴅ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$deletedmode","callback_data"=>"deletedmode"]],

[["text"=>"» ʜᴀsʜᴛᴀɢ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$hashtagmode","callback_data"=>"hashtagmode"]],

[["text"=>"» ᴍᴇɴᴛɪᴏɴ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$mentionmode","callback_data"=>"mentionmode"]],

[["text"=>"» ᴍᴇɴᴛɪᴏɴ2 ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$mention2mode","callback_data"=>"mention2mode"]],

[["text"=>"» ᴜɴᴅᴇʀʟɪɴᴇ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$underlinemode","callback_data"=>"underlinemode"]],

[["text"=>"» ʀᴇᴠᴇʀsᴇ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$reversemode","callback_data"=>"reversemode"]],

[["text"=>"» =-=-=-=-=-=-=-=-=-=-=-=-=-= «","callback_data"=>"text"],
],

[["text"=>"» ᴘɪɴɢ","callback_data"=>"text"],
["text"=>"$load[0]","callback_data"=>"text"]],

[["text"=>"» ᴍᴇᴍᴏʀʏ ᴜsɪɴɢ","callback_data"=>"text"],
["text"=>"$mem_using","callback_data"=>"text"]],

[["text" => "» ʙᴀᴄᴋ «", "callback_data" => "back"]],
]])]);
} 
//=======================================================================
if($data == "mention2mode" && in_array($fromid, $Sudo)){
$partmode=file_get_contents("../part.txt");
$time = file_get_contents("../time.txt");
$hashtagmode=file_get_contents("../hashtag.txt");
$mentionmode=file_get_contents("../mention.txt");
$boldmode=file_get_contents("../bold.txt");
$italicmode=file_get_contents("../italic.txt");
$underlinemode=file_get_contents("../underline.txt");
$deletedmode=file_get_contents("../deleted.txt");
$mention2mode = file_get_contents("../mention2.txt");
$codingmode = file_get_contents("../coding.txt");


$reversemode = file_get_contents("../reversemode.txt");

$profname = file_get_contents("../profname.txt");
$mem_using = round(memory_get_usage() / 1024 / 1024,1);
$load = sys_getloadavg();    
if ($mention2mode == "on"){
file_put_contents('../mention2.txt','off');
$mention2mode=file_get_contents("../mention2.txt");
}else{
    file_put_contents('../mention2.txt','on');
    $mention2mode=file_get_contents("../mention2.txt");
}
bot("editMessageReplyMarkup", ["text"=>"=-=-=-=-=-=-=-=-=-=-=
» ʏᴏᴜ ᴄᴀɴ ᴏɴ ᴏʀ ᴏғғ ʏᴏᴜʀ ᴍᴏᴅᴇs : 
=-=-=-=-=-=-=-=-=-=-=
","inline_message_id"=>$inline_message_id,
'parse_mode'=>"MarkDown",
"reply_markup"=>json_encode([
"inline_keyboard"=>[
[["text"=>"» ᴘᴀʀᴛ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$partmode","callback_data"=>"partmode"]],

[["text"=>"» ʙᴏʟᴅ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$boldmode","callback_data"=>"boldmode"]],

[["text"=>"» ᴛɪᴍᴇ ɴᴀᴍᴇ","callback_data"=>"text"],
["text"=>"$time","callback_data"=>"time"]],

[["text"=>"» ɪᴛᴀʟɪᴄ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$italicmode","callback_data"=>"italicmode"]],

[["text"=>"» ᴄᴏᴅɪɴɢ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$codingmode","callback_data"=>"codingmode"]],

[["text"=>"» ᴅᴇʟᴇᴛᴇᴅ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$deletedmode","callback_data"=>"deletedmode"]],

[["text"=>"» ʜᴀsʜᴛᴀɢ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$hashtagmode","callback_data"=>"hashtagmode"]],

[["text"=>"» ᴍᴇɴᴛɪᴏɴ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$mentionmode","callback_data"=>"mentionmode"]],

[["text"=>"» ᴍᴇɴᴛɪᴏɴ2 ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$mention2mode","callback_data"=>"mention2mode"]],

[["text"=>"» ᴜɴᴅᴇʀʟɪɴᴇ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$underlinemode","callback_data"=>"underlinemode"]],

[["text"=>"» ʀᴇᴠᴇʀsᴇ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$reversemode","callback_data"=>"reversemode"]],

[["text"=>"» =-=-=-=-=-=-=-=-=-=-=-=-=-= «","callback_data"=>"text"],
],

[["text"=>"» ᴘɪɴɢ","callback_data"=>"text"],
["text"=>"$load[0]","callback_data"=>"text"]],

[["text"=>"» ᴍᴇᴍᴏʀʏ ᴜsɪɴɢ","callback_data"=>"text"],
["text"=>"$mem_using","callback_data"=>"text"]],

[["text" => "» ʙᴀᴄᴋ «", "callback_data" => "back"]],
]])]);
} 
//=======================================================================
if($data == "codingmode" && in_array($fromid, $Sudo)){
$partmode=file_get_contents("../part.txt");
$time = file_get_contents("../time.txt");
$hashtagmode=file_get_contents("../hashtag.txt");
$mentionmode=file_get_contents("../mention.txt");
$boldmode=file_get_contents("../bold.txt");
$italicmode=file_get_contents("../italic.txt");
$underlinemode=file_get_contents("../underline.txt");
$deletedmode=file_get_contents("../deleted.txt");
$mention2mode = file_get_contents("../mention2.txt");
$codingmode = file_get_contents("../coding.txt");
$profname = file_get_contents("../profname.txt");
$reversemode = file_get_contents("../reversemode.txt");
$mem_using = round(memory_get_usage() / 1024 / 1024,1);
$load = sys_getloadavg();    
if ($codingmode == "on"){
file_put_contents('../coding.txt','off');
$codingmode=file_get_contents("../coding.txt");
}else{
    file_put_contents('../coding.txt','on');
    $codingmode=file_get_contents("../coding.txt");
}
bot("editMessageReplyMarkup", ["text"=>"=-=-=-=-=-=-=-=-=-=-=
» ʏᴏᴜ ᴄᴀɴ ᴏɴ ᴏʀ ᴏғғ ʏᴏᴜʀ ᴍᴏᴅᴇs : 
=-=-=-=-=-=-=-=-=-=-=
","inline_message_id"=>$inline_message_id,
'parse_mode'=>"MarkDown",
"reply_markup"=>json_encode([
"inline_keyboard"=>[
[["text"=>"» ᴘᴀʀᴛ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$partmode","callback_data"=>"partmode"]],

[["text"=>"» ʙᴏʟᴅ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$boldmode","callback_data"=>"boldmode"]],

[["text"=>"» ᴛɪᴍᴇ ɴᴀᴍᴇ","callback_data"=>"text"],
["text"=>"$time","callback_data"=>"time"]],

[["text"=>"» ɪᴛᴀʟɪᴄ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$italicmode","callback_data"=>"italicmode"]],

[["text"=>"» ᴄᴏᴅɪɴɢ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$codingmode","callback_data"=>"codingmode"]],

[["text"=>"» ᴅᴇʟᴇᴛᴇᴅ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$deletedmode","callback_data"=>"deletedmode"]],

[["text"=>"» ʜᴀsʜᴛᴀɢ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$hashtagmode","callback_data"=>"hashtagmode"]],

[["text"=>"» ᴍᴇɴᴛɪᴏɴ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$mentionmode","callback_data"=>"mentionmode"]],

[["text"=>"» ᴍᴇɴᴛɪᴏɴ2 ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$mention2mode","callback_data"=>"mention2mode"]],

[["text"=>"» ᴜɴᴅᴇʀʟɪɴᴇ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$underlinemode","callback_data"=>"underlinemode"]],

[["text"=>"» ʀᴇᴠᴇʀsᴇ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$reversemode","callback_data"=>"reversemode"]],

[["text"=>"» =-=-=-=-=-=-=-=-=-=-=-=-=-= «","callback_data"=>"text"],
],

[["text"=>"» ᴘɪɴɢ","callback_data"=>"text"],
["text"=>"$load[0]","callback_data"=>"text"]],

[["text"=>"» ᴍᴇᴍᴏʀʏ ᴜsɪɴɢ","callback_data"=>"text"],
["text"=>"$mem_using","callback_data"=>"text"]],

[["text" => "» ʙᴀᴄᴋ «", "callback_data" => "back"]],
]])]);
} 

//=======================================================================
if($data == "reversemode" && in_array($fromid, $Sudo)){
$partmode=file_get_contents("../part.txt");
$time = file_get_contents("../time.txt");
$hashtagmode=file_get_contents("../hashtag.txt");
$mentionmode=file_get_contents("../mention.txt");
$boldmode=file_get_contents("../bold.txt");
$italicmode=file_get_contents("../italic.txt");
$underlinemode=file_get_contents("../underline.txt");
$deletedmode=file_get_contents("../deleted.txt");
$mention2mode = file_get_contents("../mention2.txt");
$codingmode = file_get_contents("../coding.txt");
$profname = file_get_contents("../profname.txt");
$reversemode = file_get_contents("../reversemode.txt");
$mem_using = round(memory_get_usage() / 1024 / 1024,1);
$load = sys_getloadavg();    
if ($reversemode == "on"){
file_put_contents('../reversemode.txt','off');
$reversemode=file_get_contents("../reversemode.txt");
}else{
    file_put_contents('../reversemode.txt','on');
    $reversemode=file_get_contents("../reversemode.txt");
}
bot("editMessageReplyMarkup", ["text"=>"=-=-=-=-=-=-=-=-=-=-=
» ʏᴏᴜ ᴄᴀɴ ᴏɴ ᴏʀ ᴏғғ ʏᴏᴜʀ ᴍᴏᴅᴇs : 
=-=-=-=-=-=-=-=-=-=-=
","inline_message_id"=>$inline_message_id,
'parse_mode'=>"MarkDown",
"reply_markup"=>json_encode([
"inline_keyboard"=>[
[["text"=>"» ᴘᴀʀᴛ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$partmode","callback_data"=>"partmode"]],

[["text"=>"» ʙᴏʟᴅ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$boldmode","callback_data"=>"boldmode"]],

[["text"=>"» ᴛɪᴍᴇ ɴᴀᴍᴇ","callback_data"=>"text"],
["text"=>"$time","callback_data"=>"time"]],

[["text"=>"» ɪᴛᴀʟɪᴄ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$italicmode","callback_data"=>"italicmode"]],

[["text"=>"» ᴄᴏᴅɪɴɢ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$codingmode","callback_data"=>"codingmode"]],

[["text"=>"» ᴅᴇʟᴇᴛᴇᴅ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$deletedmode","callback_data"=>"deletedmode"]],

[["text"=>"» ʜᴀsʜᴛᴀɢ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$hashtagmode","callback_data"=>"hashtagmode"]],

[["text"=>"» ᴍᴇɴᴛɪᴏɴ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$mentionmode","callback_data"=>"mentionmode"]],

[["text"=>"» ᴍᴇɴᴛɪᴏɴ2 ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$mention2mode","callback_data"=>"mention2mode"]],

[["text"=>"» ᴜɴᴅᴇʀʟɪɴᴇ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$underlinemode","callback_data"=>"underlinemode"]],

[["text"=>"» ʀᴇᴠᴇʀsᴇ ᴍᴏᴅᴇ","callback_data"=>"text"],
["text"=>"$reversemode","callback_data"=>"reversemode"]],

[["text"=>"» =-=-=-=-=-=-=-=-=-=-=-=-=-= «","callback_data"=>"text"],
],

[["text"=>"» ᴘɪɴɢ","callback_data"=>"text"],
["text"=>"$load[0]","callback_data"=>"text"]],

[["text"=>"» ᴍᴇᴍᴏʀʏ ᴜsɪɴɢ","callback_data"=>"text"],
["text"=>"$mem_using","callback_data"=>"text"]],

[["text" => "» ʙᴀᴄᴋ «", "callback_data" => "back"]],
]])]);
}