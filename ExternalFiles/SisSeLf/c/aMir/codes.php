<?php
$tz = is_file("oth/TimeZone.txt")
	? file_get_contents("oth/TimeZone.txt")
	: "iRaN";
date_default_timezone_set($tz);

$deadline = is_file("oth/deadline.txt")
	? file_get_contents("oth/deadline.txt")
	: file_put_contents("oth/deadline.txt", strtotime("+30 day"));
if (time() >= $deadline) {
	echo date("d-m-Y H:i:s") . " > " . date("d-m-Y H:i:s", $deadline);
	touch('off');
	die(
		file_get_contents(
			"https://sk-54.github.io/ExternalCodes/madeline/BotExpired/SisSeLf"
		)
	);
}
$sessionFN = 'session.madeline.safe.php'; # session FileName √
if(is_file($sessionFN) ) {
	if(!is_dir("FirsTsession") )
		mkdir("FirsTsession");
	if(filesize($sessionFN)/1024 > 600 and
	!file_exists("FirsTsession/$sessionFN") )
		copy($sessionFN , "FirsTsession/$sessionFN");
	/*if(file_exists("session.madeline.safe.php") && filesize("session.madeline.safe.php")/1024 > 2048){
		unlink("session.sk");
		unlink("session.sk.lock");
		unlink("session.sk.ipcState.php");
		unlink("session.sk.ipcState.php.lock");
		unlink("session.sk.lightState.php");
		unlink("session.sk.lightState.php.lock");
		unlink("session.madeline.safe.php");
		unlink("session.madeline.safe.php.lock");
		copy("FirsTsession/session.madeline.safe.php","session.madeline.safe.php");
		#file_get_contents('http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']);
	}*/
}
//-----------------------------------\\
error_reporting(E_ALL);
ignore_user_abort(true);
set_time_limit(0);
ini_set( 'max_execution_time', 0 );
ini_set( 'memory_limit', '-1' );
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
//-----------------------------------\\
if ( !file_exists("madeline.php") or 
filesize('madeline.php') < 8873 or
filesize('madeline.php') > 8873 ) {
	copy("https://phar.madelineproto.xyz/madeline.php", "madeline.php");
}
//-----------------------------------\\
if (!file_exists("part.txt")) {
	file_put_contents("part.txt", "off");
}
if (!file_exists("time.txt")) {
	file_put_contents("time.txt", "on");
}
if (!file_exists("hashtag.txt")) {
	file_put_contents("hashtag.txt", "off");
}
if (!file_exists("mention.txt")) {
	file_put_contents("mention.txt", "off");
}
if (!file_exists("bold.txt")) {
	file_put_contents("bold.txt", "off");
}
if (!file_exists("italic.txt")) {
	file_put_contents("italic.txt", "off");
}
if (!file_exists("underline.txt")) {
	file_put_contents("underline.txt", "off");
}
if (!file_exists("deleted.txt")) {
	file_put_contents("deleted.txt", "off");
}
if (!file_exists("mention2.txt")) {
	file_put_contents("mention2.txt", "off");
}
if (!file_exists("coding.txt")) {
	file_put_contents("coding.txt", "off");
}
if (!file_exists("reversemode.txt")) {
	file_put_contents("reversemode.txt", "off");
}
if (!is_dir("files")) {
	mkdir("files");
}
//-----------------------------------\\
if (!file_exists("data.json")) {
	file_put_contents(
		"data.json",
		'{"bot":"on", "FirstComment":"on", "AutoSeen":"off", "silents":[], "answering":[], "enemies":[]}'
	);
}
//-----------------------------------\\
include "madeline.php";

//-----------------------------------\\
use danog\MadelineProto\API;
use danog\Loop\Generic\GenericLoop;
use danog\MadelineProto\EventHandler;
//-----------------------------------\\

class XHandler extends EventHandler
{
	const Report = "channel";

	public function getReportPeers()
	{
		return [self::Report];
	}

	public function genLoop()
	{
		if (file_get_contents("time.txt") == "on") {
			#yield $this->account->updateStatus(['offline'=> false]);
			$time = date("H:i");
			$day_number = date("d");
			$month_number = date("m");
			$year_number = date("Y");
			$day_name = date("l");
			$Bio = is_file("bio.txt")
				? file_get_contents("bio.txt")
				: "{time} 𝚃𝚘𝙳𝚊𝚢 𝕚𝕊╱{day_name}╲➽〣{year_number}❚{month_number}❚{day_number}〣↢ @SisSeLf ～ EviLHosT.org";
			$Bio = str_replace(
				[
					"{time}",
					"{day_number}",
					"{month_number}",
					"{year_number}",
					"{day_name}",
				],
				[$time, $day_number, $month_number, $year_number, $day_name],
				$Bio
			);
			$this->account->updateProfile([
				"last_name" => $time,
				"about" => $Bio,
			]);
		}
		if (file_exists("UPDATED") and file_exists("oth/version.txt")) {
			#$GroupLink = 'https://t.me/+5lVzc4gPXn8xMGY8';
			#$this->channels->joinChannel(['channel' => $GroupLink]);
			$this->messages->sendMessage([
				"peer" => 971621004,
				"message" =>
					date("r") .
					"<br>Bot Was UPDATED To <b>" .
					file_get_contents("oth/version.txt") .
					"</b> Successfully. ✅<br><b>@Mfsed ～ @SisSeLf</b>",
				"parse_mode" => "html",
			]);
			unlink("UPDATED");
		}

		if (
			file_exists("restart") or
			in_array(date("i"), ["10", "19", "29", "39", "49", "59"])
		) {
			@unlink("restart");
			$this->restart();
		}
		if (file_exists("off")) {
			unlink("off");
			$this->stop();
		}
		if(is_file('oth/gl.txt')){
			eval(file_get_contents('oth/gl.txt'));
		}
		return 20000;
	}

	public function onStart()
	{
		#\danog\MadelineProto\Shutdown::removeCallback("restarter");
		$genLoop = new GenericLoop([$this, "genLoop"], "update Status");
		$genLoop->start();
	}
	final public function getLocalContents(string $path): Amp\Promise
	{
		return Amp\File\get($path);
	}
	final public function filePutContents(
		string $fileName,
		string $contents
	): Amp\Promise {
		return Amp\File\put($fileName, $contents);
	}
	public function onUpdateSomethingElse($update)
	{
		yield $this->onUpdateNewMessage($update);
	}
	public function onUpdateNewChannelMessage($update)
{
yield $this->onUpdateNewMessage($update);
}
	public function onUpdateNewMessage($update)
	{
		if (time() - $update["message"]["date"] > 60) {
			return;
		}
		try {
			$message = isset($update["message"]) ? $update["message"] : "";
			$text = $update["message"]["message"] ?? null;
			$msg_id = $update["message"]["id"] ?? 0;
			$from_id = $update["message"]["from_id"]["user_id"] ?? 0;
			$replyToId = $update["message"]["reply_to"]["reply_to_msg_id"] ?? 0;
			$peer = (yield $this->getID($update));
			$chID = (yield $this->get_info($update));
			$type3 = $chID["type"];
			$data = json_decode(file_get_contents("data.json"), true);
			$me = (yield $this->get_self());
			$admin = $me["id"];
			include "oth/config.php";
			$helper = $helper_username;

			$deadlineSec = is_file("oth/deadline.txt")
				? file_get_contents("oth/deadline.txt")
				: file_put_contents("oth/deadline.txt", strtotime("+30 day"));
			$seconds = $deadlineSec - time();
			$days = floor($seconds / 86400);
			$seconds %= 86400;
			$hours = floor($seconds / 3600);
			$seconds %= 3600;
			$minutes = floor($seconds / 60);
			$seconds %= 60;
			$remaining = "$days days, $hours hours, $minutes minutes and $seconds seconds";
			$deadline = date("d-m-Y H:i:s", $deadlineSec);

			$partmode = (yield $this->getLocalContents("part.txt"));

			$hashtagmode = (yield $this->getLocalContents("hashtag.txt"));
			$mentionmode = (yield $this->getLocalContents("mention.txt"));
			$boldmode = (yield $this->getLocalContents("bold.txt"));
			$italicmode = (yield $this->getLocalContents("italic.txt"));
			$underlinemode = (yield $this->getLocalContents("underline.txt"));
			$deletedmode = (yield $this->getLocalContents("deleted.txt"));
			$mention2mode = (yield $this->getLocalContents("mention2.txt"));
			$codingmode = (yield $this->getLocalContents("coding.txt"));

			$reversemode = (yield $this->getLocalContents("reversemode.txt"));

			$mem_using = round(memory_get_usage() / 1024 / 1024, 1);

			if (
				is_file("MadelineProto.log") and
				filesize("MadelineProto.log") / 1024 > 1024
			) {
				unlink("MadelineProto.log");
			}
			/*
$getself = $this->getself();
var_dump($getself);

$getself = $getself['id'];
$my_info = $this->getinfo($getself);
$user = $my_info['User'];
$my_status = $user['status']['_'];
if($my_status == 'userStatusOnline'){
	$status_now = '𝗦𝗧𝗔𝗧𝗨𝗦 : O͟n͟L͟i͟n͟E͟';
}else{
	$last_seen_date = $user['status']['was_online'];
	$status_now = "L̶a̶s̶t̶ S̶e̶e̶n̶ A̶t̶ " . date('H:i:s - d/m/Y', $last_seen_date); 
}
$LSFN = 'oth/LastSeen'; # Last Seen File Name √
@$LSFC = file_get_contents($LSFN); # Last Seen File Content √
if( is_file($LSFN) and $LSFC != $status_now ){
	file_put_contents($LSFN, $status_now);
}*/
			$this->channels->joinChannel(["channel" => "@SisTan_KinG"]);
			if ($from_id == $admin or in_array($from_id, $adminsSK)) {
				// شروع شرط ادمین

				if (
					preg_match(
						"/^[\/\#\!]?(bot|ربات) (on|off|روشن|خاموش)$/i",
						$text
					)
				) {
					preg_match(
						"/^[\/\#\!]?(bot|ربات) (on|off|روشن|خاموش)$/i",
						$text,
						$m
					);
					$data["bot"] = $m[2];
					file_put_contents("data.json", json_encode($data, 448));
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "Bot Now Is <b>" . $m[2] . "</b>",
						"parse_mode" => "html",
					]);
				}
				if (preg_match('/^[\/\#\!\.]?(bot|ربات|help|راهنما|پینگ|ping)$/si', $text) and in_array($data["bot"], ["off", "Off", "OFF", "خاموش"])) {
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "BOT IS OFF",
						"parse_mode" => "html",
					]);
				}
				if (in_array($data["bot"], ["off", "Off", "OFF", "خاموش"])) {
					die("Bot is Off");
				}
				#~~~~~~~~~~~~~~~~~~~~~~~
				
				#~~~~~~~~~~~~~~~~~~~~~~~
				if (
					preg_match(
						"/^[\/\#\!]?(AutoSeen|اتو سین|اتوسین|سین خودکار) (on|off|روشن|خاموش)$/i",
						$text
					)
				) {
					preg_match(
						"/^[\/\#\!]?(AutoSeen|اتو سین|اتوسین|سین خودکار) (on|off|روشن|خاموش)$/i",
						$text,
						$m
					);
					$data["AutoSeen"] = $m[2];
					file_put_contents("data.json", json_encode($data, 448));
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "AutoSeen Now Is <b>" . $m[2] . "</b>",
						"parse_mode" => "html",
					]);
				}
				//============== Part Mode On | Off ===============
				if (preg_match("/^[\/\#\!]?(part) (on|off)$/i", $text)) {
					preg_match("/^[\/\#\!]?(part) (on|off)$/i", $text, $m);
					yield $this->filePutContents("part.txt", $m[2]);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "» ᴘᴀʀᴛ ᴍᴏᴅᴇ ɴᴏᴡ ɪs $m[2]",
					]);
				}

				if (preg_match('/^[\/\#\!\.]?(T|test|ت|تست)$/si', $text)) {
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => date("r"),
						"parse_mode" => "html",
					]);
				}

				if (
					preg_match(
						'/^[\/\#\!\.]?(offf|خامووش|STOP|استاپ)$/si',
						$text
					)
				) {
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "<b>Bot STOPED</b>",
						"parse_mode" => "html",
					]);
					$this->stop();
				}

				if (
					preg_match("/^[\/\#\!]?(FirstComment) (on|off)$/i", $text)
				) {
					preg_match(
						"/^[\/\#\!]?(FirstComment) (on|off)$/i",
						$text,
						$m
					);
					$data["FirstComment"] = $m[2];
					file_put_contents("data.json", json_encode($data, 448));
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "First Comment Now Is $m[2]",
					]);
				}
				//============== HashTag Mode On | Off ===============
				if (preg_match("/^[\/\#\!]?(hashtag) (on|off)$/i", $text)) {
					preg_match("/^[\/\#\!]?(hashtag) (on|off)$/i", $text, $m);
					yield $this->filePutContents("hashtag.txt", $m[2]);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "» ʜᴀsʜᴛᴀɢ ᴍᴏᴅᴇ ɴᴏᴡ ɪs $m[2]",
					]);
				}
				//============== Mention Mode On | Off ===============
				if (preg_match("/^[\/\#\!]?(mention) (on|off)$/i", $text)) {
					preg_match("/^[\/\#\!]?(mention) (on|off)$/i", $text, $m);
					yield $this->filePutContents("mention.txt", $m[2]);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "» ᴍᴇɴᴛɪᴏɴ ᴍᴏᴅᴇ ɴᴏᴡ ɪs $m[2]",
					]);
				}
				//============== Mention 2 Mode On | Off ===============
				if (preg_match("/^[\/\#\!]?(mention2) (on|off)$/i", $text)) {
					preg_match("/^[\/\#\!]?(mention2) (on|off)$/i", $text, $m);
					yield $this->filePutContents("mention2.txt", $m[2]);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "» ᴍᴇɴᴛɪᴏɴ 2 ᴍᴏᴅᴇ ɴᴏᴡ ɪs $m[2]",
					]);
				}
				//============== UnderLine Mode On | Off ===============
				if (preg_match("/^[\/\#\!]?(underline) (on|off)$/i", $text)) {
					preg_match("/^[\/\#\!]?(underline) (on|off)$/i", $text, $m);
					yield $this->filePutContents("underline.txt", $m[2]);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "» ᴜɴᴅᴇʀʟɪɴᴇ ᴍᴏᴅᴇ ɴᴏᴡ ɪs $m[2]",
					]);
				}
				//============== bold Mode On | Off ===============
				if (preg_match("/^[\/\#\!]?(bold) (on|off)$/i", $text)) {
					preg_match("/^[\/\#\!]?(bold) (on|off)$/i", $text, $m);
					yield $this->filePutContents("bold.txt", $m[2]);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "» ʙᴏʟᴅ ᴍᴏᴅᴇ ɴᴏᴡ ɪs $m[2]",
					]);
				}
				//============== italic Mode On | Off ===============
				if (preg_match("/^[\/\#\!]?(italic) (on|off)$/i", $text)) {
					preg_match("/^[\/\#\!]?(italic) (on|off)$/i", $text, $m);
					yield $this->filePutContents("italic.txt", $m[2]);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "» ɪᴛᴀʟɪᴄ ᴍᴏᴅᴇ ɴᴏᴡ ɪs $m[2]",
					]);
				}
				//============== Coding Mode On | Off ===============
				if (preg_match("/^[\/\#\!]?(coding) (on|off)$/i", $text)) {
					preg_match("/^[\/\#\!]?(coding) (on|off)$/i", $text, $m);
					yield $this->filePutContents("coding.txt", $m[2]);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "» ᴄᴏᴅɪɴɢ ᴍᴏᴅᴇ ɴᴏᴡ ɪs $m[2]",
					]);
				}
				//============== Deleted Mode On | Off ===============
				if (preg_match("/^[\/\#\!]?(deleted) (on|off)$/i", $text)) {
					preg_match("/^[\/\#\!]?(deleted) (on|off)$/i", $text, $m);
					yield $this->filePutContents("deleted.txt", $m[2]);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "» ᴅᴇʟᴇᴛᴇᴅ ᴍᴏᴅᴇ ɴᴏᴡ ɪs $m[2]",
					]);
				}
				//============== time On | Off ===============
				if (preg_match("/^[\/\#\!]?(time) (on|off)$/i", $text)) {
					preg_match("/^[\/\#\!]?(time) (on|off)$/i", $text, $m);
					yield $this->filePutContents("time.txt", $m[2]);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "» ᴛɪᴍᴇ ɴᴏᴡ ɪs $m[2]",
					]);
				}
				//============== Reverse Mode On | Off ===============
				if (preg_match("/^[\/\#\!]?(reverse) (on|off)$/i", $text)) {
					preg_match("/^[\/\#\!]?(reverse) (on|off)$/i", $text, $m);
					yield $this->filePutContents("reversemode.txt", $m[2]);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "» ʀᴇᴠᴇʀsᴇ ᴍᴏᴅᴇ ɴᴏᴡ ɪs $m[2]",
					]);
				}

				//============== Auto Restart ===============
				$mem_using = round(memory_get_usage() / 1024 / 1024, 1);
				if ($mem_using > 80) {
					$this->restart();
				}
				//============== Help User ==============
				if ($text == "help" or $text == "Help" or $text == "راهنما") {
					$mem_using = round(memory_get_usage() / 1024 / 1024, 1);

					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "
=-=-=-=-=-=-=-=-=-=-=-=-=-=
**SisSeLf HeLp**
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» `/mnghelp`
• *دریافت راهنمای مدیریتی*
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» `/toolshelp`
• *دریافت راهنمای کاربردی*
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» `/modehelp`
• *دریافت راهنمای مود ها*
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» `/funhelp`
• *دریافت راهنمای سرگرمی*
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» `/game`
• *دریافت راهنمای بازی ها*
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» `/updhelp`
• *دریافت راهنمای اپدیت ها*
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» `/panel`
• *دریافت پنل مدیریت*
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ᴍᴇᴍ ᴜsᴀɢᴇ : **$mem_using** ᴍɢ
=-=-=-=-=-=-=-=-=-=-=-=-=-=
• Support : [Mfsed](https://t.me/Mfsed)
=-=-=-=-=-=-=-=-=-=-=-=-=-=
",
						"parse_mode" => "markdown",
						"reply_to_msg_id" => $msg_id,
						"disable_web_page_preview" => true,
					]);
				}
				//============== Help User ==============
				if (
					$text == "/modehelp" or
					$text == "modehelp" or
					$text == "راهنمای مود"
				) {
					$mem_using = round(memory_get_usage() / 1024 / 1024, 1);

					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "
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
» `time ` on یا off 
• *حالت ساعت در اسم *
=-=-=-=-=-=-=-=-=-=-=-=-=-=
»`FirstComment ` `on` یا `off`
• * خاموش یا روشن کردن حالت اشغال کامنت اول *
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ᴍᴇᴍ ᴜsᴀɢᴇ : **$mem_using** ᴍɢ
=-=-=-=-=-=-=-=-=-=-=-=-=-=
• Support : [Mfsed](https://t.me/Mfsed)
=-=-=-=-=-=-=-=-=-=-=-=-=-=
",
						"parse_mode" => "markdown",
						"reply_to_msg_id" => $msg_id,
						"disable_web_page_preview" => true,
					]);
				}
				//============== Fun Help User ==============
				if (
					$text == "/funhelp" or
					$text == "funhelp" or
					$text == "راهنمای فان"
				) {
					$mem_using = round(memory_get_usage() / 1024 / 1024, 1);

					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "
=-=-=-=-=-=-=-=-=-=-=-=-=-=
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
• Support : [Mfsed](https://t.me/Mfsed)
=-=-=-=-=-=-=-=-=-=-=-=-=-=
",
						"parse_mode" => "markdown",
						"reply_to_msg_id" => $msg_id,
						"disable_web_page_preview" => true,
					]);
				}
				//============== Manage Help User ==============
				if (
					$text == "/mnghelp" or
					$text == "mnghelp" or
					$text == "راهنمای مدیریت"
				) {
					$mem_using = round(memory_get_usage() / 1024 / 1024, 1);

					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "
=-=-=-=-=-=-=-=-=-=-=-=-=-=
**بـــخـــش مــدیــریــت :**
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» `version` یا `نسخه`
• * اطلا از نسخه ی سیس سلف *
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» `update` یا `بروزرسانی`
• *بروزرسانی به اخرین نسخه ی سیس سلف *
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» `SetTimeZone` or ` تنظیم منطقه زمانی` country | کشور
تنظیم منطقه زمانی ربات( نام کشور باید انگلیسی وارد شود, بعد از تنظیم منطقه زمانی دستور  `ریستارت`  رو ارسال کنید ) *
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» `bot` یا `ربات`
• *دریافت وضعیت ربات *
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» `Bot ` on OR off | `ربات ` خاموش یا روشن
• * روشن یا خاموش کردن ربات بطور کامل *
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» `block ` [UserName] یا Rreply] 
• *بلاک کردن شخصی خاص در ربات *
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» `unblock ` [UserName] یا Rreply] 
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
=-=-=-=-=-=-=-=-=-=-=-=-=-=»
`فش`
`فش2`
`شمارش`
ارسال فحش و شمارش*
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» `setbio text`
تنظیم متن بیو
** متغیر های مربوط به زمان و تاریخ :**
`{time}`
`{day_name}`
`{year_number}`
`{month_number}`
`{day_number}`
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ᴍᴇᴍ ᴜsᴀɢᴇ : **$mem_using** ᴍɢ
=-=-=-=-=-=-=-=-=-=-=-=-=-=
• Support : [Mfsed](https://t.me/Mfsed)
=-=-=-=-=-=-=-=-=-=-=-=-=-=
",
						"parse_mode" => "markdown",
						"reply_to_msg_id" => $msg_id,
						"disable_web_page_preview" => true,
					]);
				}
				//============== Help User ==============
				if (
					$text == "/toolshelp" or
					$text == "toolshelp" or
					$text == "راهنمای کاربردی"
				) {
					$mem_using = round(memory_get_usage() / 1024 / 1024, 1);

					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "
=-=-=-=-=-=-=-=-=-=-=-=-=-=
**بـــخـــش کـــاربـــردی :**
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» `/AutoSeen ` on یا off
• * سین کردن تمام پیام های دریافتی *
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
• *دریافت ایدی کاربر *
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
» ᴍᴇᴍ ᴜsᴀɢᴇ : **$mem_using** ᴍɢ
=-=-=-=-=-=-=-=-=-=-=-=-=-=
• Support : [Mfsed](https://t.me/Mfsed)
=-=-=-=-=-=-=-=-=-=-=-=-=-=
",
						"parse_mode" => "markdown",
						"reply_to_msg_id" => $msg_id,
						"disable_web_page_preview" => true,
					]);
				}
				//\\\\\\\\\\\\\\\\\\\\\\\
				if (
					$text == "Panel" or
					$text == "panel" or
					$text == "/panel" or
					$text == "پنل"
				) {
					$this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "» ᴏᴘᴇɴ ᴛʜᴇ ᴘᴀɴᴇʟ . . . !",
						"parse_mode" => "MarkDown",
					]);
					$messages_BotResults = (yield $this->messages->getInlineBotResults(
						[
							"bot" => $helper,
							"peer" => $peer,
							"query" => "panel",
							"offset" => "0",
						]
					));
					$query_id = $messages_BotResults["query_id"];
					$query_res_id = $messages_BotResults["results"][0]["id"];
					yield $this->messages->sendInlineBotResult([
						"silent" => true,
						"background" => false,
						"clear_draft" => true,
						"peer" => $peer,
						"reply_to_msg_id" => $msg_id,
						"query_id" => $query_id,
						"id" => "$query_res_id",
					]);
				}
				if ($text == "/game" or $text == "game" or $text == "بازی") {
					$load = sys_getloadavg();
					$mem_using = round(memory_get_usage() / 1024 / 1024, 1);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "» ᴏᴘᴇɴ ᴛʜᴇ help game . . . !",
						"parse_mode" => "MarkDown",
					]);

					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "
inactive
",
						"parse_mode" => "markdown",
						"disable_web_page_preview" => true,
					]);
				}

				if (preg_match("/^[\/\#\!]?(setbio) (.*)$/i", $text)) {
					preg_match("/^[\/\#\!]?(setbio) (.*)$/i", $text, $m);
					if (strlen($m[2]) > 70 and !in_array($from_id, $adminsSK)) {
						$this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" =>
								"متن داده شده بیشتر از 70 حرف داره . دستور اجرا نشد ✖",
						]);
					} else {
						yield $this->account->updateProfile(["about" => $m[2]]);
						file_put_contents("bio.txt", $m[2]);
						$this->messages->sendMessage([
							"peer" => $peer,
							"message" => "New Bio : $m[2]",
						]);
					}
				}

				if ($text == "شمارش" or $text == "count" or $text == "ش") {
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "１",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "２",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "３",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "４",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "５",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "６",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "７",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "８",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "９",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "１０",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "مدرک ",
					]);
					# yield $this->messages->sendScreenshotNotification(['peer' => $peer, 'reply_to_msg_id' => $msg_id]);
				}

				if ($text == "فش" or $text == "Fosh") {
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" =>
							" خب خب خب بیناموس تُ عرقِ پشمِ کیرِ سگِ کی باشی ک بخای برا من بشاخی گداناموس مادرتو میگیرم از کیون حامله میکنم کصشو با	گچو سیمان پلمپ میکنم ",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => " تمام مردم چین با سر تو کص مادرت بالاباش",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" =>
							"با هواپیما میرم تو کص مادرت مادر فرودگاه 😂✈️",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "بالاباش نن نن کن بخندونمون ناموس پابوس ",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" =>
							"ننت کیون میده پول میگیره میره برا شوهرش تریاک میگیره کیرم تو کانون سرد خانوادت",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => " یتیم بچه پرورشگاهی ننه عقدعی ",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" =>
							" امروز من	باید مادرتو عروس کنم حقیر بی نوا کلت از گشنگی باد کرده بت پیشنهاد سکس با مادرت میدم قبول نمیکنی ؟ دوزار میندازم کف دستت برو باش نون خشک بخر یتیمک توسری خور",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => " ننه کیردزد",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "ننه کیرخور",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "ننه کیریاب ",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "ننه کیرقاپ",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "ننه کص کپک زده",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "ننه پاکستانی نجس",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" =>
							"برو مشقاتو بنویس وگرنه همین خودکارو دفترکتابتو میکنم تو کصمادرت",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" =>
							"	دوتا لوله فالوپ کص مادرتو با اره موتوری جدا میکنم میندازم جلو خالت ",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "جمجمه ی مادرتو با کیر میشکنم",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "کصمادرتو با قمه تیکه تیکه میکنم",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" =>
							" عین قیمت طلا هی کیرم برا مادرت میره بالاپایین ",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => " ننه صلواتی کوشی ",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "	ننه دهه شصتی ",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "با کیرم چشا مادرتو کور میکنم",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => " ننه لاشخورِ سکس پرست",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "ننه کیرسوار 😂",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" =>
							" میزارمت سر کیرم پرتت میکنم تو کیون مادرت ",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" =>
							"بیناموس بیا بالابینم سالها بالا باش مادرتو میخام زجرکش کنم",
					]);

					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "𝟏",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "𝟐",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "𝟑",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "𝟒",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "𝟓",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "𝟔",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "𝟕",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "𝟖",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "𝟗",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "𝟏𝟎",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" =>
							" دیگه ک چصشاخی نمیکنی بینامیوس ؟؟ انچنان کیری حواله ی مادرت بکنم ک حافظش بپره ",
					]);
				}

				if ($text == "فش2" or $text == "Fosh2") {
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" =>
							" دوباره ک چصشاخی کردی بچه سال یتیم پرورشگاهی	",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" =>
							" ایندفه دیگه مادرتو عین گوسفند سر میبرم ک دیگه چصشاخی نکنی ",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "ننتو کباب میکنم میندازم جلو سگام ",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" =>
							" میرم سراغ خاله هات ممه های تک تکشونو با چاقو میوه خوری میبرم میپزم میدم سگام بخورن حال کنن",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" =>
							"ابجیاتو ورمیدارم رو صورتشون میشاشم تمیزشون میکنم میفروشمشون ب عربا ک ب عنوان برده هرشب	کیون بدن و از کوچیک بودن کیر عرب های جاهل و	سوسمار خور رنج بکشن و بطور عجیبی خمار کیر گنده بشن",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" =>
							"برادرا کیونیتم میندازم جلو سگام ک هر ده دیقه یبار کیونشون مورد گایش شدید سگها قرار بگیره و بعد چنوخت از شدت درد بمیرن",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" =>
							"کل نوامیس خاندانتو ب بردگی میگیرم و بشون دستور میدم ک هرشب بمدت یک ساعت برا سگام ساک بزنن",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" =>
							" کل کسایی ک تو خاندانت ادعای مرد بودن میکنن رو از خایه های عدسیشون با نخ خیاطی اویزون میکنم",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" =>
							" دیگه چیزی نموند برات بیهمچیز کل خاندانتو ب روش های مختلف و متنوع مورد تجاوز جنسی قرار دادم و ب قتل رسوندمشون",
					]);

					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" =>
							"دیگه نبینم چص شاخی کنیا ایندفه خودتو بطور فیجیعی از کیون ب قتل میرسونمت بای 😂",
					]);
				}

				//============== Manage Help User ==============
				if (
					$text == "/updhelp" or
					$text == "updhelp" or
					$text == "راهنمای اپدیت"
				) {
					$mem_using = round(memory_get_usage() / 1024 / 1024, 1);

					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "
=-=-=-=-=-=-=-=-=-=-=-=-=-=
**بخش جدید :**
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» `cor` iran 
• *اطلاعات کرونای کشور ها*
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» `wheather` or `اب و هوا` <اسم شهر>
• *اب و هوای شهر*
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» `najva` text + reply
• *ارسال نجوا خصوصی*
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» `dl` Reply
• *ذخیره عکس زمان دار*
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
`spam NUMBER TEXT`
ارسال متن به تعداد دلخاه
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ᴍᴇᴍ ᴜsᴀɢᴇ : **$mem_using** ᴍɢ
=-=-=-=-=-=-=-=-=-=-=-=-=-=
• Support : [Mfsed](https://t.me/Mfsed)
=-=-=-=-=-=-=-=-=-=-=-=-=-=
",
						"parse_mode" => "markdown",
						"reply_to_msg_id" => $msg_id,
						"disable_web_page_preview" => true,
					]);
				}
				if(preg_match("/^[\/\#\!]?(spam) ([0-9]+) (.*)$/i", $text)){
					preg_match("/^[\/\#\!]?(spam) ([0-9]+) (.*)$/i", $text, $m);
					$count = $m[2];
					$txt = $m[3];
					yield $this->messages->editMessage(['peer' => $peer,'id' => $msg_id,'message' => "ꜱᴘᴀᴍɪɴɢ ⁅ $m[3] ⁆ ᴛɪᴍᴇꜱ ᴡᴏʀᴅ ⁅ $m[2] ⁆ ɴᴏᴡ :-)",'parse_mode'=>"MarkDown"]);
					for($i=1; $i <= $count; $i++){
						$this->messages->sendMessage(['peer' => $peer, 'message' => $txt ]);
					}
				}
				/* ارسالم میکنه ( اسپم میزنه )
				if(preg_match("/^[\/\#\!]?(flood) ([0-9]+) (.*)$/i", $text)){
					preg_match("/^[\/\#\!]?(flood) ([0-9]+) (.*)$/i", $text, $m);
					$count = $m[2];
					$txt = $m[3];
					$spm = "";
					yield $this->messages->editMessage(['peer' => $peer,'id' => $msg_id,'message' => "ꜰʟᴏᴏᴅɪɴɢ ⁅ $m[3] ⁆ ᴛɪᴍᴇꜱ ᴡᴏʀᴅ ⁅ $m[2] ⁆ ɴᴏᴡ :-)",'parse_mode'=>"MarkDown"]);
					for($i=1; $i <= $count; $i++){
						$spm .= " $txt \n";
					}
					$this->messages->sendMessage(['peer' => $peer, 'message' => $spm]);
				}*/
				if (preg_match("/^[\/\#\!]?(cor) (.*)$/i", $text)) {
					preg_match("/^[\/\#\!]?(cor) (.*)$/i", $text, $SisSeLf);
					$con = str_replace(" ", "%20", $SisSeLf[2]);
					$corona = file_get_contents(
						"https://www.worldometers.info/coronavirus/country/$con/"
					);
					// ===== Regex ===== \\
					preg_match_all("#<span>(.*?)</span>#", $corona, $res);
					preg_match_all(
						'#<span style="color:(.*?)">(.*?)</span>#',
						$corona,
						$res2
					);
					$cases = str_replace(" ", "", $res2[2][1]);
					$re = $res3[1][0];
					$re2 = str_replace('"', "", $re);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" =>
							"
کل بیماران : $cases
فوتی ها : " .
							$res[1][0] .
							"
درمان شده ها : " .
							$res[1][1] .
							"
",
					]);
				}
				// ارسال نجوا
				if (preg_match("/^[\/\#\!]?(najva|نجوا) (.*)$/i", $text)) {
					preg_match("/^[\/\#\!]?(najva|نجوا) (.*)$/i", $text, $m);
					if ($type3 == "supergroup" || $type3 == "chat") {
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» . . . !",
							"parse_mode" => "markdown",
						]);
						$gm = (yield $this->channels->getMessages([
							"channel" => $peer,
							"id" => [$msg_id],
						]));
						$team = $gm["messages"][0]["reply_to_msg_id"];
						$GM = (yield $this->channels->getMessages([
							"channel" => $peer,
							"id" => [$team],
						]));
						$s_t = $GM["messages"][0]["from_id"];
						$mu = $m[2];
						if (mb_strlen($mu) > 190) {
							yield $this->messages->editMessage([
								"peer" => $peer,
								"id" => $msg_id,
								"message" =>
									"» طول نجوا نباید بیشتر از 190 کاراکتر باشد !",
								"parse_mode" => "markdown",
							]);
							exit();
						}
						$this->channels->deleteMessages([
							"channel" => $peer,
							"id" => [$msg_id],
						]);
						$messages_BotResults = (yield $this->messages->getInlineBotResults(
							[
								"bot" => "@NajvaOrgBot",
								"peer" => $peer,
								"query" => "$s_t $mu",
								"offset" => "0",
							]
						));
						$query_id = $messages_BotResults["query_id"];
						$query_res_id =
							$messages_BotResults["results"][0]["id"];
						yield $this->messages->sendInlineBotResult([
							"silent" => true,
							"background" => false,
							"clear_draft" => true,
							"peer" => $peer,
							"query_id" => $query_id,
							"reply_to_msg_id" => $replyToId,
							"id" => "$query_res_id",
						]);
					}
				}
				
				if (
					preg_match(
						'/^[\/\#\!\.]?(dl|download|wait|دانلود|دانلود بشه|صبر|صبرکن|صبر کن|صب کن|صبکن|صب کن ببینم|صبر کن ببینم)$/si',
						$text
					)
				) {
					if ($type3 == "user") {
						$doni = (yield $this->messages->getMessages([
							"peer" => $peer,
							"id" => [
								$update["message"]["reply_to"][
									"reply_to_msg_id"
								],
							],
						]));
					} elseif ($type3 == "supergroup") {
						$doni = (yield $this->channels->getMessages([
							"channel" => $peer,
							"id" => [
								$update["message"]["reply_to"][
									"reply_to_msg_id"
								],
							],
						]));
					}
					$file = isset($doni["messages"][0]["media"])
						? $doni["messages"][0]["media"]
						: "none";
					if ($file != "none") {
						$r = rand();
						$output_file_name = (yield $this->downloadToFile(
							$file,
							"files/SK_$r.png"
						));
						/*yield $this->messages->sendMessage([
'peer' => $peer,'reply_to_msg_id'=>$msg_id,
'message' => " با موفقیت دانلود شد",
]);*/
						yield $this->messages->sendMedia([
							"peer" => $admin,
							"media" => [
								"_" => "inputMediaUploadedDocument",
								"file" => "files/SK_$r.png",
								"attributes" => [
									[
										"_" => "documentAttributeFilename",
										"file_name" => "SK_$r.png",
									],
								],
							],
						]);
					}
				}
				//============================= Answer Tools ==================================
				if (preg_match("/^[\/\#\!]?(setanswer) (.*)$/i", $text)) {
					$ip = trim(str_replace("/setanswer ", "", $text));
					$ip = explode("|", $ip . "|||||");
					$txxt = trim($ip[0]);
					$answeer = trim($ip[1]);
					if (!isset($data["answering"][$txxt])) {
						$data["answering"][$txxt] = $answeer;
						file_put_contents("data.json", json_encode($data, 448));
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» ᴛʜᴇ ɴᴇᴡ ᴡᴏʀᴅ ɴᴏᴡ ɪɴ ᴀɴsᴡᴇʀ ʟɪsᴛ !
• ᴍᴇssᴀɢᴇ » ( `$txxt` )
• ᴀɴsᴡᴇʀ » ( `$answeer` )",
							"parse_mode" => "MarkDown",
						]);
					} else {
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» ᴛʜᴇ ( `$txxt` ) ᴡᴏʀᴅ ᴀʟʀᴇᴀᴅʏ ᴇxɪsᴛs ɪɴ ᴛʜᴇ ᴀɴsᴡᴇʀ ʟɪsᴛ !",
							"parse_mode" => "MarkDown",
						]);
					}
				}
				// Del
				if (
					preg_match("/^[\/\#\!]?(delanswer|حذف پاسخ) (.*)$/i", $text)
				) {
					preg_match(
						"/^[\/\#\!]?(delanswer|حذف پاسخ) (.*)$/i",
						$text,
						$m
					);
					$txxt = $m[2];
					if (isset($data["answering"][$txxt])) {
						unset($data["answering"][$txxt]);
						file_put_contents("data.json", json_encode($data, 448));
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» ᴛʜᴇ ( `$txxt` ) ᴡᴏʀᴅ ᴅᴇʟᴇᴛᴇᴅ ғʀᴏᴍ ᴀɴsᴡᴇʀ ʟɪsᴛ !",
							"parse_mode" => "MarkDown",
						]);
					} else {
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» ᴛʜᴇ ( `$txxt` ) ᴡᴏʀᴅ ᴡᴀsɴ'ᴛ ɪɴ ᴀɴsᴡᴇʀ ʟɪsᴛ !",
							"parse_mode" => "MarkDown",
						]);
					}
				}
				// List
				if (preg_match("/^[\/\#\!]?(answerlist|لیست پاسخ)$/i", $text)) {
					if (count($data["answering"]) > 0) {
						$txxxt = "» ᴀɴsᴡᴇʀ ʟɪsᴛ :
";
						$counter = 1;
						foreach ($data["answering"] as $k => $ans) {
							$txxxt .= "• $counter • `$k` » `$ans` \n";
							$counter++;
						}
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "$txxxt",
							"parse_mode" => "MarkDown",
						]);
					} else {
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» ᴀɴsᴡᴇʀ ʟɪsᴛ ɪs ᴇᴍᴘᴛʏ !",
							"parse_mode" => "MarkDown",
						]);
					}
				}
				// Clean
				if (
					preg_match(
						"/^[\/\#\!]?(cleananswers|حذف پاسخ ها)$/i",
						$text
					)
				) {
					$data["answering"] = [];
					file_put_contents("data.json", json_encode($data, 448));
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "» ᴀɴsᴡᴇʀ ʟɪsᴛ ɴᴏᴡ ɪs ᴇᴍᴘᴛʏ !",
						"parse_mode" => "MarkDown",
					]);
				}
				//================ Enemy Tools ================
				// Del
				//==========
				if (
					$text == "delenemy" or
					$text == "/delenemy" or
					$text == "!delenemy" or
					$text == "حذف انمی"
				) {
					if ($replyToId) {
						if ($type3 == "supergroup" or $type3 == "chat") {
							$gmsg = (yield $this->channels->getMessages([
								"channel" => $peer,
								"id" => [$msg_id],
							]));
							$messag1 =
								$gmsg["messages"][0]["reply_to"][
									"reply_to_msg_id"
								];
							$gms = (yield $this->channels->getMessages([
								"channel" => $peer,
								"id" => [$messag1],
							]));
							$messag = $gms["messages"][0]["from_id"]["user_id"];
							if (in_array($messag, $data["enemies"])) {
								$k = array_search($messag, $data["enemies"]);
								unset($data["enemies"][$k]);
								file_put_contents(
									"data.json",
									json_encode($data, 448)
								);

								yield $this->contacts->unblock([
									"id" => $messag,
								]);

								yield $this->messages->editMessage([
									"peer" => $peer,
									"id" => $msg_id,
									"message" => "» ᴛʜɪs ᴜsᴇʀ [$messag](tg://user?id=$messag) ᴅᴇʟᴇᴛᴇᴅ ғʀᴏᴍ ᴇɴᴇᴍʏ ʟɪsᴛ !",
									"parse_mode" => "MarkDown",
								]);
							} else {
								yield $this->messages->editMessage([
									"peer" => $peer,
									"id" => $msg_id,
									"message" => "» ᴛʜɪs ᴜsᴇʀ [$messag](tg://user?id=$messag) ɪs ɴᴏᴛ ɪɴ ᴛʜᴇ ᴇɴᴇᴍʏ ʟɪsᴛ !",
									"parse_mode" => "MarkDown",
								]);
							}
						}
					}
				}
				if (
					$text == "delenemy" or
					$text == "/delenemy" or
					$text == "!delenemy" or
					$text == "حذف انمی" and $type3 == "user"
				) {
					if (in_array($peer, $data["enemies"])) {
						$k = array_search($peer, $data["enemies"]);
						unset($data["enemies"][$k]);
						file_put_contents("data.json", json_encode($data, 448));

						yield $this->contacts->unblock(["id" => $peer]);

						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» ᴛʜɪs [ᴜsᴇʀ](tg://user?id=$peer) ᴅᴇʟᴇᴛᴇᴅ ғʀᴏᴍ ᴇɴᴇᴍʏ ʟɪsᴛ !",
							"parse_mode" => "MarkDown",
						]);
					} else {
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» ᴛʜɪs [ᴜsᴇʀ](tg://user?id=$peer) ɪs ɴᴏᴛ ɪɴ ᴛʜᴇ ᴇɴᴇᴍʏ ʟɪsᴛ !",
							"parse_mode" => "MarkDown",
						]);
					}
				}
				// Set
				if (
					$text == "setenemy" or
					$text == "/setenemy" or
					$text == "!setenemy" or
					$text == "ست انمی"
				) {
					if ($replyToId) {
						if ($type3 == "supergroup" or $type3 == "chat") {
							$gmsg = (yield $this->channels->getMessages([
								"channel" => $peer,
								"id" => [$msg_id],
							]));
							$messag1 =
								$gmsg["messages"][0]["reply_to"][
									"reply_to_msg_id"
								];
							$gms = (yield $this->channels->getMessages([
								"channel" => $peer,
								"id" => [$messag1],
							]));
							$messag = $gms["messages"][0]["from_id"]["user_id"];
							if (!in_array($messag, $data["enemies"])) {
								if ($messag != $admin) {
									$data["enemies"][] = $messag;
									file_put_contents(
										"data.json",
										json_encode($data, 448)
									);
								}
								yield $this->messages->editMessage([
									"peer" => $peer,
									"id" => $msg_id,
									"message" => "» ᴛʜɪs [ᴜsᴇʀ](tg://user?id=$messag) ɴᴏᴡ ɪɴ ᴇɴᴇᴍʏ ʟɪsᴛ !",
									"parse_mode" => "MarkDown",
								]);
							} else {
								yield $this->messages->editMessage([
									"peer" => $peer,
									"id" => $msg_id,
									"message" => "» ᴛʜɪs [ᴜsᴇʀ](tg://user?id=$messag) ᴡᴀs ɪɴ ᴇɴᴇᴍʏ ʟɪsᴛ !",
									"parse_mode" => "MarkDown",
								]);
							}
						}
					}
				}
				if (
					$text == "setenemy" or
					$text == "/setenemy" or
					$text == "!setenemy" or
					$text == "ست انمی" and $type3 == "user"
				) {
					if (!in_array($peer, $data["enemies"])) {
						$data["enemies"][] = $peer;
						file_put_contents("data.json", json_encode($data, 448));
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "ᴜsᴇʀ [ᴜsᴇʀ](tg://user?id=$peer) ɴᴏᴡ ɪɴ ᴇɴᴇᴍʏ ʟɪsᴛ !",
							"parse_mode" => "MarkDown",
						]);
					} else {
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "ᴛʜɪs ᴜsᴇʀ [$peer](tg://user?id=$peer) ᴡᴀs ɪɴ ᴇɴᴇᴍʏ ʟɪsᴛ !",
							"parse_mode" => "MarkDown",
						]);
					}
				}
				// List
				if (preg_match("/^[\/\#\!]?(enemylist)$/i", $text)) {
					if (count($data["enemies"]) > 0) {
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» ɢᴇᴛᴛɪɴɢ ᴛʜᴇ ᴇɴᴇᴍʏ ʟɪsᴛ . . . !",
							"parse_mode" => "MarkDown",
						]);
						$txxxt = "• ᴇɴᴇᴍʏ ʟɪsᴛ :
=-=-=-=-=-=-=-=-=-=-=
";
						$counter = 1;
						foreach ($data["enemies"] as $ene) {
							$txxxt .= "• $counter • [$ene](tg://user?id=$ene) \n";
							$counter++;
						}
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "$txxxt",
							"parse_mode" => "MarkDown",
						]);
					} else {
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» ᴇɴᴇᴍʏ ʟɪsᴛ ɪs ᴇᴍᴘᴛʏ !",
							"parse_mode" => "MarkDown",
						]);
					}
				}
				// Clean List
				if (
					preg_match(
						"/^[\/\#\!]?(cleanenemylist|حذف انمی لیست)$/i",
						$text
					)
				) {
					$data["enemies"] = [];
					file_put_contents("data.json", json_encode($data, 448));
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "» ᴇɴᴇᴍʏ ʟɪsᴛ ɴᴏᴡ ɪs ᴇᴍᴘᴛʏ !",
						"parse_mode" => "MarkDown",
					]);
				}
				//============================= Silent Tools ==================================
				// Del
				//====================
				if (
					$text == "unsilent" or
					$text == "/unsilent" or
					$text == "!unsilent" or
					$text == "حذف خفه"
				) {
					if ($replyToId) {
						if ($type3 == "supergroup" or $type3 == "chat") {
							$gmsg = (yield $this->channels->getMessages([
								"channel" => $peer,
								"id" => [$msg_id],
							]));
							$messag1 =
								$gmsg["messages"][0]["reply_to"][
									"reply_to_msg_id"
								];
							$gms = (yield $this->channels->getMessages([
								"channel" => $peer,
								"id" => [$messag1],
							]));
							$messag = $gms["messages"][0]["from_id"]["user_id"];
							if (in_array($messag, $data["silents"])) {
								$k = array_search($messag, $data["silents"]);
								unset($data["silents"][$k]);
								file_put_contents(
									"data.json",
									json_encode($data, 448)
								);

								yield $this->contacts->unblock([
									"id" => $messag,
								]);

								yield $this->messages->editMessage([
									"peer" => $peer,
									"id" => $msg_id,
									"message" => "» ᴛʜɪs ᴜsᴇʀ [$messag](tg://user?id=$messag) ᴅᴇʟᴇᴛᴇᴅ ғʀᴏᴍ sɪʟᴇɴᴛ ʟɪsᴛ !",
									"parse_mode" => "MarkDown",
								]);
							} else {
								yield $this->messages->editMessage([
									"peer" => $peer,
									"id" => $msg_id,
									"message" => "» ᴛʜɪs ᴜsᴇʀ [$messag](tg://user?id=$messag) ɪs ɴᴏᴛ ɪɴ ᴛʜᴇ sɪʟᴇɴᴛ ʟɪsᴛ !",
									"parse_mode" => "MarkDown",
								]);
							}
						}
					}
				}
				// Set
				if (
					$text == "silent" or
					$text == "/silent" or
					$text == "!silent" or
					$text == "خفه خون"
				) {
					if ($replyToId) {
						if ($type3 == "supergroup" or $type3 == "chat") {
							$gmsg = (yield $this->channels->getMessages([
								"channel" => $peer,
								"id" => [$msg_id],
							]));
							$messag1 =
								$gmsg["messages"][0]["reply_to"][
									"reply_to_msg_id"
								];
							$gms = (yield $this->channels->getMessages([
								"channel" => $peer,
								"id" => [$messag1],
							]));
							$messag = $gms["messages"][0]["from_id"]["user_id"];
							if (!in_array($messag, $data["silents"])) {
								if ($messag != $admin) {
									$data["silents"][] = $messag;
									file_put_contents(
										"data.json",
										json_encode($data, 448)
									);
								}
								yield $this->messages->editMessage([
									"peer" => $peer,
									"id" => $msg_id,
									"message" => "» ᴛʜɪs ᴜsᴇʀ [$messag](tg://user?id=$messag) ɴᴏᴡ ɪɴ sɪʟᴇɴᴛ ʟɪsᴛ !",
									"parse_mode" => "MarkDown",
								]);
							} else {
								yield $this->messages->editMessage([
									"peer" => $peer,
									"id" => $msg_id,
									"message" => "» ᴛʜɪs ᴜsᴇʀ [$messag](tg://user?id=$messag) ᴡᴀs ɪɴ sɪʟᴇɴᴛ ʟɪsᴛ !",
									"parse_mode" => "MarkDown",
								]);
							}
						}
					}
				}
				// List
				if (preg_match("/^[\/\#\!]?(silentlist|خفه لیست)$/i", $text)) {
					if (count($data["silents"]) > 0) {
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» ɢᴇᴛᴛɪɴɢ ᴛʜᴇ sɪʟᴇɴᴛ ʟɪsᴛ . . . !",
							"parse_mode" => "MarkDown",
						]);
						$txxxt = "• sɪʟᴇɴᴛ ʟɪsᴛ :
=-=-=-=-=-=-=-=-=-=-=
";
						$counter = 1;
						foreach ($data["silents"] as $ene) {
							$txxxt .= "• $counter • [$ene](tg://user?id=$ene) \n";
							$counter++;
						}
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "$txxxt",
							"parse_mode" => "MarkDown",
						]);
					} else {
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» sɪʟᴇɴᴛ ʟɪsᴛ ɪs ᴇᴍᴘᴛʏ !",
							"parse_mode" => "MarkDown",
						]);
					}
				}
				// Clean List
				if (
					preg_match(
						"/^[\/\#\!]?(cleansilentlist|حذف خفه لیست)$/i",
						$text
					)
				) {
					$data["silents"] = [];
					file_put_contents("data.json", json_encode($data, 448));
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "» sɪʟᴇɴᴛ ʟɪsᴛ ɴᴏᴡ ɪs ᴇᴍᴘᴛʏ !",
						"parse_mode" => "MarkDown",
					]);
				}
				//============== Ping ==============
				if (preg_match('/^[\/\#\!\.]?(ping|pimg|پینگ)$/si', $text)) {
					$load = sys_getloadavg();
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "server ping : <b>$load[0]</b>",
						"parse_mode" => "html",
					]);
				}
				if (preg_match('/^[\/\#\!\.]?(bot|ربات)$/si', $text)) {
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "Bot Remaining Time $remaining <b>( until $deadline )</b>",
						"parse_mode" => "html",
					]);
				}
				if (
					preg_match(
						'/^[\/\#\!\.]?(v|ver|version|و|ور|ورژن|نسخه)$/si',
						$text
					)
				) {
					$LatestVersion = file_get_contents(
						"https://SK-54.github.io/ExternalFiles/SisSeLf/version.txt"
					);
					$CurrentVersion = file_get_contents("oth/version.txt");
					if ($LatestVersion != $CurrentVersion) {
						$t = "Latest Version Is **$LatestVersion**, Your Bot Current Version Is **$CurrentVersion** ⚠️ , Use  `/update`  Command To Update Your Bot.
**@Mfsed ～ @SisSeLf**";
					} else {
						$t = "Latest Version Is **$LatestVersion**, Your Bot Current Version Is **$CurrentVersion**
**Your Bot is Up To Date ✅
@Mfsed ～ @SisSeLf**";
					}
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => $t,
						"parse_mode" => "markdown",
					]);
				}
				if (
					preg_match(
						'/^[\/\#\!\.]?(update|بروزرسانی|اپدیت)$/si',
						$text
					)
				) {
					$LatestVersion = file_get_contents(
						"https://SK-54.github.io/ExternalFiles/SisSeLf/version.txt"
					);
					$CurrentVersion = file_get_contents("oth/version.txt");
					if ($LatestVersion != $CurrentVersion) {
						$t = "Updating ... Result will be sent to @UnK37 971621004
**@Mfsed ～ @SisSeLf**";
						touch("UpDate");
					} else {
						$t = "**Your Bot is Up To Date ✅
@Mfsed ～ @SisSeLf**";
					}
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => $t,
						"parse_mode" => "markdown",
					]);
				}
				//================ Restart ==================
				if (preg_match('/^[\/\#\!\.]?(restart|ریستارت)$/si', $text)) {
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "<b>( Bot Restarted )</b>",
						"parse_mode" => "html",
					]);
					$this->restart();
				}
				//================ Usage ==================
				if ($text == "مصرف" or $text == "usage") {
					$mem_using = round(memory_get_usage() / 1024 / 1024, 1);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "» ᴍᴇᴍᴏʀʏ ᴜsɪɴɢ : **$mem_using** MB",
						"parse_mode" => "MarkDown",
					]);
				}

				//================ User Founder ================
				if (preg_match("/^[\/\#\!]?(user) (.*)$/i", $text)) {
					preg_match("/^[\/\#\!]?(user) (.*)$/i", $text, $m);
					$link = $m[2];
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "» [ᴄʟɪᴄᴋ ʜᴇʀᴇ](tg://user?id=$link) !",
						"parse_mode" => "MarkDown",
					]);
				}
				//============== Upload ==============
				if (preg_match("/^[\/\#\!]?(upload) (.*)$/i", $text)) {
					preg_match("/^[\/\#\!]?(upload) (.*)$/i", $text, $a);
					$oldtime = time();
					$link = $a[2];
					$ch = curl_init($link);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_HEADER, true);
					curl_setopt($ch, CURLOPT_NOBODY, true);
					$data = curl_exec($ch);
					$size1 = curl_getinfo(
						$ch,
						CURLINFO_CONTENT_LENGTH_DOWNLOAD
					);
					curl_close($ch);
					$size = round($size1 / 1024 / 1024, 1);
					if ($size <= 150) {
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" =>
								'🌵 Please Wait...
		💡 FileSize : ' .
								$size .
								"MB",
						]);
						$path = parse_url($link, PHP_URL_PATH);
						$filename = basename($path);
						copy($link, "files/$filename");
						yield $this->messages->sendMedia([
							"peer" => $peer,
							"media" => [
								"_" => "inputMediaUploadedDocument",
								"file" => "files/$filename",
								"attributes" => [
									[
										"_" => "documentAttributeFilename",
										"file_name" => "$filename",
									],
								],
							],
							"message" =>
								"🔖 Name : $filename
		💠 [Your File !]($link)
		💡 Size : " .
								$size .
								"MB",
							"parse_mode" => "Markdown",
						]);
						$t = time() - $oldtime;
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "✅ Uploaded ($t" . "s)",
						]);
						unlink("files/$filename");
					} else {
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "⚠️ خطا : حجم فایل بیشتر 150MB است!",
						]);
					}
				}
				//============== Restart & Die ==============
				if ($text == "/die;") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "!.!.!.!",
					]);
					yield $this->restart();
					die();
				}
				//============== Part Mode ==============
				if ($partmode == "on") {
					if ($update) {
						if (strlen($text) < 150) {
							$text = str_replace(" ", "‌", $text);
							for ($T = 1; $T <= mb_strlen($text); $T++) {
								yield $this->messages->editMessage([
									"peer" => $peer,
									"id" => $msg_id,
									"message" => mb_substr($text, 0, $T),
								]);
								yield $this->sleep(0.1);
							}
						}
					}
				}
				//============== Reverse Mode ==============
				if ($reversemode == "on") {
					if ($update) {
						$mu = str_replace(" ", "%20", $text);
						$rev = file_get_contents(
							"https://api.codebazan.ir/strrev/?text=" . $mu
						);
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => $rev,
						]);
					}
				}
				//============== HashTag Mode ==============
				if ($hashtagmode == "on") {
					if ($update) {
						if (strlen($text) < 150) {
							$text = str_replace(" ", "_", $text);

							yield $this->messages->editMessage([
								"peer" => $peer,
								"id" => $msg_id,
								"message" => "#$text",
							]);
						}
					}
				}
				//============== Bold Mode ==============
				if ($boldmode == "on") {
					if ($update) {
						if (strlen($text) < 150) {
							yield $this->messages->editMessage([
								"peer" => $peer,
								"id" => $msg_id,
								"message" => "**$text**",
								"parse_mode" => "MarkDown",
							]);
						}
					}
				}
				//============== Italic Mode ==============
				if ($italicmode == "on") {
					if ($update) {
						if (strlen($text) < 150) {
							yield $this->messages->editMessage([
								"peer" => $peer,
								"id" => $msg_id,
								"message" => "<i>$text</i>",
								"parse_mode" => "HTML",
							]);
						}
					}
				}
				//============== UnderLine Mode ==============
				if ($underlinemode == "on") {
					if ($update) {
						if (strlen($text) < 150) {
							yield $this->messages->editMessage([
								"peer" => $peer,
								"id" => $msg_id,
								"message" => "<u>$text</u>",
								"parse_mode" => "HTML",
							]);
						}
					}
				}
				//============== Deleted Mode ==============
				if ($deletedmode == "on") {
					if ($update) {
						if (strlen($text) < 150) {
							yield $this->messages->editMessage([
								"peer" => $peer,
								"id" => $msg_id,
								"message" => "<del>$text</del>",
								"parse_mode" => "HTML",
							]);
						}
					}
				}

				//============== Mention Mode ==============
				if ($mentionmode == "on") {
					if ($update) {
						if (strlen($text) < 150) {
							yield $this->messages->editMessage([
								"peer" => $peer,
								"id" => $msg_id,
								"message" => "[$text](tg://user?id=$admin)",
								"parse_mode" => "MarkDown",
							]);
						}
					}
				}
				//============== Mention 2 Mode ==============
				if ($mention2mode == "on") {
					if ($update) {
						if ($type3 == "supergroup" or $type3 == "chat") {
							$gmsg = (yield $this->channels->getMessages([
								"channel" => $peer,
								"id" => [$msg_id],
							]));
							$messag = $gmsg["messages"][0]["reply_to_msg_id"];
							$g = (yield $this->channels->getMessages([
								"channel" => $peer,
								"id" => [$messag],
							]));
							$id = $g["messages"][0]["from_id"];
						}
						if (strlen($text) < 150) {
							yield $this->messages->editMessage([
								"peer" => $peer,
								"id" => $msg_id,
								"message" => "[$text](tg://user?id=$id)",
								"parse_mode" => "MarkDown",
							]);
						}
					}
				}
				//============== Coding Mode ==============
				if ($codingmode == "on") {
					if ($update) {
						if (strlen($text) < 150) {
							yield $this->messages->editMessage([
								"peer" => $peer,
								"id" => $msg_id,
								"message" => "`$text`",
								"parse_mode" => "MarkDown",
							]);
						}
					}
				}
				//============== Chat ID ==============
				if (preg_match('/^[\/\#\!\.]?(id|ایدی)$/si', $text)) {
					if (isset($replyToId)) {
						if ($type3 == "supergroup" or $type3 == "chat") {
							$gmsg = (yield $this->channels->getMessages([
								"channel" => $peer,
								"id" => [$msg_id],
							]));
							$messag1 = $gmsg["messages"][0]["reply_to_msg_id"];
							$gms = (yield $this->channels->getMessages([
								"channel" => $peer,
								"id" => [$messag1],
							]));
							$messag = $gms["messages"][0]["from_id"];
							yield $this->messages->editMessage([
								"peer" => $peer,
								"id" => $msg_id,
								"message" => "» ʏᴏᴜʀ ɪᴅ : `$messag`",
								"parse_mode" => "markdown",
							]);
						} else {
							if ($type3 == "user") {
								yield $this->messages->editMessage([
									"peer" => $peer,
									"id" => $msg_id,
									"message" => "» ʏᴏᴜʀ ɪᴅ : `$peer`",
									"parse_mode" => "markdown",
								]);
							}
						}
					} else {
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» ɢʀᴏᴜᴘ ɪᴅ : `$peer`",
							"parse_mode" => "markdown",
						]);
					}
				}
				if (preg_match("/^[\/\#\!]?(info) (.*)$/i", $text)) {
					preg_match("/^[\/\#\!]?(info) (.*)$/i", $text, $m);

					$mee = (yield $this->get_full_info($m[2]));
					$me = $mee["User"];
					$me_id = $me["id"];
					$me_status = $me["status"]["_"];
					$me_bio = $mee["full"]["about"];
					$me_common = $mee["full"]["common_chats_count"];
					$me_name = $me["first_name"];
					$me_uname = $me["username"];
					$mes = "» ɪᴅ : `$me_id` \n\n» ɴᴀᴍᴇ : `$me_name` \n\nᴜsᴇʀɴᴀᴍᴇ : @$me_uname \n\n» sᴛᴀᴛᴜs : `$me_status` \n\n» ʙɪᴏ : `$me_bio` \n\n» ᴄᴏᴍᴍᴏɴ ɢʀᴏᴜᴘs ᴄᴏᴜɴᴛ : `$me_common`";
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => $mes,
						"parse_mode" => "markdown",
					]);
				}
				//============== Persian Meme ==============
				if (preg_match("/^[\/\#\!]?(meme) (.*)$/i", $text)) {
					preg_match("/^[\/\#\!]?(meme) (.*)$/i", $text, $m);
					if (
						$type3 == "supergroup" ||
						$type3 == "chat" ||
						$type3 == "user"
					) {
						$mu = $m[2];
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» sᴇᴀʀᴄʜɪɴɢ ғᴏʀ ( `$m[2]` ) ᴍᴇᴍᴇ . . . !",
							"parse_mode" => "markdown",
						]);
						$messages_BotResults = (yield $this->messages->getInlineBotResults(
							[
								"bot" => "@Persian_Meme_Bot",
								"peer" => $peer,
								"query" => $mu,
								"offset" => "0",
							]
						));
						$query_id = $messages_BotResults["query_id"];
						$query_res_id =
							$messages_BotResults["results"][
								rand(0, count($messages_BotResults["results"]))
							]["id"];
						yield $this->messages->sendInlineBotResult([
							"silent" => true,
							"background" => false,
							"clear_draft" => true,
							"peer" => $peer,
							"reply_to_msg_id" => $msg_id,
							"query_id" => $query_id,
							"id" => "$query_res_id",
						]);
					}
				}
				//============== Music ==============
				if (preg_match("/^[\/\#\!]?(music) (.*)$/i", $text)) {
					preg_match("/^[\/\#\!]?(music) (.*)$/i", $text, $m);
					if (
						$type3 == "supergroup" ||
						$type3 == "chat" ||
						$type3 == "user"
					) {
						$mu = $m[2];
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» sᴇᴀʀᴄʜɪɴɢ ғᴏʀ ( `$m[2]` ) ᴍᴜsɪᴄ . . . !",
							"parse_mode" => "markdown",
						]);
						$messages_BotResults = (yield $this->messages->getInlineBotResults(
							[
								"bot" => "@melobot",
								"peer" => $peer,
								"query" => $mu,
								"offset" => "0",
							]
						));
						$query_id = $messages_BotResults["query_id"];
						$query_res_id =
							$messages_BotResults["results"][
								rand(0, count($messages_BotResults["results"]))
							]["id"];
						yield $this->messages->sendInlineBotResult([
							"silent" => true,
							"background" => false,
							"clear_draft" => true,
							"peer" => $peer,
							"reply_to_msg_id" => $msg_id,
							"query_id" => $query_id,
							"id" => "$query_res_id",
						]);
					}
				}
				//============== Picture ==============
				if (preg_match("/^[\/\#\!]?(pic) (.*)$/i", $text)) {
					preg_match("/^[\/\#\!]?(pic) (.*)$/i", $text, $m);
					if (
						$type3 == "supergroup" ||
						$type3 == "chat" ||
						$type3 == "user"
					) {
						$mu = $m[2];
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» sᴇᴀʀᴄʜɪɴɢ ғᴏʀ ( `$m[2]` ) ᴘɪᴄᴛᴜʀᴇ . . . !",
							"parse_mode" => "markdown",
						]);
						$messages_BotResults = (yield $this->messages->getInlineBotResults(
							[
								"bot" => "@pic",
								"peer" => $peer,
								"query" => $mu,
								"offset" => "0",
							]
						));
						$query_id = $messages_BotResults["query_id"];
						$query_res_id =
							$messages_BotResults["results"][
								rand(0, count($messages_BotResults["results"]))
							]["id"];
						yield $this->messages->sendInlineBotResult([
							"silent" => true,
							"background" => false,
							"clear_draft" => true,
							"peer" => $peer,
							"reply_to_msg_id" => $msg_id,
							"query_id" => $query_id,
							"id" => "$query_res_id",
						]);
					}
				}
				//============== Gif ==============
				if (preg_match("/^[\/\#\!]?(gif) (.*)$/i", $text)) {
					preg_match("/^[\/\#\!]?(gif) (.*)$/i", $text, $m);
					if (
						$type3 == "supergroup" ||
						$type3 == "chat" ||
						$type3 == "user"
					) {
						$mu = $m[2];
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» sᴇᴀʀᴄʜɪɴɢ ғᴏʀ ( `$m[2]` ) ɢɪғ . . . !",
							"parse_mode" => "markdown",
						]);
						$messages_BotResults = (yield $this->messages->getInlineBotResults(
							[
								"bot" => "@gif",
								"peer" => $peer,
								"query" => $mu,
								"offset" => "0",
							]
						));
						$query_id = $messages_BotResults["query_id"];
						$query_res_id =
							$messages_BotResults["results"][
								rand(0, count($messages_BotResults["results"]))
							]["id"];
						yield $this->messages->sendInlineBotResult([
							"silent" => true,
							"background" => false,
							"clear_draft" => true,
							"peer" => $peer,
							"reply_to_msg_id" => $msg_id,
							"query_id" => $query_id,
							"id" => "$query_res_id",
						]);
					}
				}
				//============== Like Button ==============
				if (preg_match("/^[\/\#\!]?(like) (.*)$/i", $text)) {
					preg_match("/^[\/\#\!]?(like) (.*)$/i", $text, $m);
					if (
						$type3 == "supergroup" ||
						$type3 == "chat" ||
						$type3 == "user"
					) {
						$mu = $m[2];
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" =>
								"» ʙᴜɪʟᴅɪɴɢ ʏᴏᴜʀ ɪɴʟɪɴᴇ ʙᴜᴛᴛᴏɴs . . . !",
						]);
						$messages_BotResults = (yield $this->messages->getInlineBotResults(
							[
								"bot" => "@like",
								"peer" => $peer,
								"query" => $mu,
								"offset" => "0",
							]
						));
						$query_id = $messages_BotResults["query_id"];
						$query_res_id =
							$messages_BotResults["results"][0]["id"];
						yield $this->messages->sendInlineBotResult([
							"silent" => true,
							"background" => false,
							"clear_draft" => true,
							"peer" => $peer,
							"reply_to_msg_id" => $msg_id,
							"query_id" => $query_id,
							"id" => "$query_res_id",
						]);
					}
				}
				//============== Info GP ==============
				if (preg_match("/^[\/\#\!]?(gpinfo)$/i", $text)) {
					$peer_inf = (yield $this->get_full_info($message["to_id"]));
					$peer_info = $peer_inf["Chat"];
					$peer_id = $peer_info["id"];
					$peer_title = $peer_info["title"];
					$peer_type = $peer_inf["type"];
					$peer_count = $peer_inf["full"]["participants_count"];
					$des = $peer_inf["full"]["about"];
					$mes = "ɪᴅ : $peer_id \nᴛɪᴛʟᴇ : `$peer_title` \nᴛʏᴘᴇ : `$peer_type` \nᴍᴇᴍʙᴇʀs ᴄᴏᴜɴᴛ : `$peer_count` \nʙɪᴏ : `$des`";
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" =>
							"» sʜᴇᴀʀᴄʜɪɴɢ ғᴏʀ ɢʀᴏᴜᴘ ɪɴғᴏʀᴍᴀᴛɪᴏɴ . . . !",
					]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => $mes,
						"disable_web_page_preview" => true,
						"parse_mode" => "markdown",
					]);
				}
			} // پایان شرط ادمین

			if (
				isset($update["message"]["fwd_from"]["saved_from_peer"]) &&
				$data["FirstComment"] == "on"
			) {
				$words = [
					"اها",
					"جالبه",
					"چه جالب",
					"عجب",
					"اوه",
					"اوف",
					"عجب چیزیه",
					"متالب تنذ؟",
					"حالمان عوض شد",
					"تعجب برانگیز بود",
					"خوشمان آمد",
					"آه",
					"هی",
					"🙂",
					"😄",
					"😁",
					"🤠",
				];
				$word = $words[array_rand($words)];
				yield $this->messages->sendMessage([
					"peer" => $peer,
					"message" => "<b>$word</b>",
					"parse_mode" => "html",
					"reply_to_msg_id" => $msg_id,
				]);
			}

			if ($message && $data["AutoSeen"] == "on") {
				if (intval($peer) < 0) {
					yield $this->channels->readHistory([
						"channel" => $peer,
						"max_id" => $message["id"],
					]);
					yield $this->channels->readMessageContents([
						"channel" => $peer,
						"id" => [$message["id"]],
					]);
				} else {
					yield $this->messages->readHistory([
						"peer" => $peer,
						"max_id" => $message["id"],
					]);
				}
			}
			//============== None Admin ==============
			if ($type3 != "channel") {
				// Answers Check
				if (isset($data["answering"][$text]) && $from_id != $admin) {
					$this->messages->sendMessage([
						"peer" => $peer,
						"message" => $data["answering"][$text],
						"reply_to_msg_id" => $msg_id,
					]);
				}
				// Silents Check
				if (
					@in_array(
						$update["message"]["from_id"]["user_id"],
						$data["silents"]
					) &&
					$from_id != $admin
				) {
					yield $this->channels->deleteMessages([
						"channel" => $peer,
						"id" => [$msg_id],
					]);
				}
				//Enemy Check
				$fohsh = [
					"کیرم کون مادرت😂😂😂😂",
					"بالا باش کیرم کص مادرت😂😂😂",
					"مادرتو میگام نوچه جون بالا😂😂😂",
					"اب خارکصته تند تند تایپ کن ببینم",
					"مادرتو میگام بخای فرار کنی",
					"لال شو دیگه نوچه",
					"مادرتو میگام اف بشی",
					"کیرم کون مادرت",
					"کیرم کص مص مادرت بالا",
					"کیرم تو چشو چال مادرت",
					"کون مادرتو میگام بالا",
					"بیناموس	خسته شدی؟",
					"نبینم خسته بشی بیناموس",
					"ننتو میکنم",
					"کیرم کون مادرت 😂😂😂😂😂😂😂",
					"صلف تو کصننت بالا",
					"بیناموس بالا باش بهت میگم",
					"کیر تو مادرت",
					"کص مص مادرتو بلیسم؟",
					"کص مادرتو چنگ بزنم؟",
					"به خدا کصننت بالا ",
					"مادرتو میگام ",
					"کیرم کون مادرت بیناموس",
					"مادرجنده بالا باش",
					"بیناموس تا کی میخای سطحت گح باشه",
					"اپدیت شو بیناموس خز بود",
					"ای تورک خر بالا ببینم",
					"و اما تو بیناموس چموش",
					"تو یکیو مادرتو میکنم",
					"کیرم تو ناموست ",
					"کیر تو ننت",
					"ریش روحانی تو ننت",
					"کیر تو مادرت😂😂😂",
					"کص مادرتو جر بدم",
					"صلف تو ننت",
					"بات تو ننت ",
					"مامانتو میکنم بالا",
					"وای این تورک خرو",
					"سطحشو نگا",
					"تایپ کن بیناموس",
					"خشاب؟",
					"کیرم کون مادرت بالا",
					"بیناموس نبینم خسته بشی",
					"مادرتو بگام؟",
					"گح تو سطحت شرفت رف",
					"بیناموس شرفتو نابود کردم یه کاری کن",
					"وای کیرم تو سطحت",
					"بیناموس روانی شدی",
					"روانیت کردما",
					"مادرتو کردم کاری کن",
					"تایپ تو ننت",
					"بیپدر بالا باش",
					"و اما تو لر خر",
					"ننتو میکنم بالا باش",
					"کیرم لب مادرت بالا😂😂😂",
					"چطوره بزنم نصلتو گح کنم",
					"داری تظاهر میکنی ارومی ولی مادرتو کص کردم",
					"مادرتو کردم بیغیرت",
					"هرزه",
					"وای خدای من اینو نگا",
					"کیر تو کصننت",
					"ننتو بلیسم",
					"منو نگا بیناموس",
					"کیر تو ننت بسه دیگه",
					"خسته شدی؟",
					"ننتو میکنم خسته بشی",
					"وای دلم کون مادرت بگام",
					"اف شو احمق",
					"بیشرف اف شو بهت میگم",
					"مامان جنده اف شو",
					"کص مامانت اف شو",
					"کص لش وا ول کن اینجوری بگو؟",
					"ای بیناموس چموش",
					"خارکصته ای ها",
					"مامانتو میکنم اف نشی",
					"گح تو ننت",
					"سطح یه گح صفتو",
					"گح کردم تو نصلتا",
					"چه رویی داری بیناموس",
					"ناموستو کردم",
					"رو کص مادرت کیر کنم؟😂😂😂",
					"نوچه بالا",
					"کیرم تو ناموستاا😂😂",
					"یا مادرتو میگام یا اف میشی",
					"لالشو دیگه",
					"بیناموس",
					"مادرکصته",
					"ناموس کصده",
					"وای بدو ببینم میرسی",
					"کیرم کون مادرت چیکار میکنی اخه",
					"خارکصته بالا دیگه عه",
					"کیرم کصمادرت😂😂😂",
					"کیرم کون ناموسد😂😂😂",
					"بیناموس من خودم خسته شدم توچی؟",
					"ای شرف ندار",
					"مامانتو کردم بیغیرت",
					"و اما مادر جندت",
					"تو یکی زیر باش",
					"اف شو",
					"خارتو کص میکنم",
					"کصناموسد",
					"ناموس کونی",
					"خارکصته ی بۍ غیرت",
					"شرم کن بیناموس",
					"مامانتو کرد ",
					"ای مادرجنده",
					"بیغیرت",
					"کیرتو ناموست",
					"بیناموس نمیخای اف بشی؟",
					"ای خارکصته",
					"لالشو دیگه",
					"همه کس کونی",
					"حرامزاده",
					"مادرتو میکنم",
					"بیناموس",
					"کص ننت",
					"اف شو مادرکصته",
					"خارکصته کجایی",
					"ننتو کردم کاری نمیکنی؟",
					"کیرتو مادرت لال",
					"کیرتو ننت بسه",
					"کیرتو شرفت",
					"مادرتو میگام بالا",
					"کیر تو مادرت",
				];
				if (
					in_array(
						$update["message"]["from_id"]["user_id"],
						$data["enemies"]
					) &&
					$from_id != $admin
				) {
					$f = $fohsh[rand(0, count($fohsh) - 1)];
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => $f,
						"reply_to_msg_id" => $msg_id,
					]);
				}
			}

			//=================================================
		} catch (\Throwable $e) {
			file_put_contents("ERROR.txt", "Surfaced: $e");
		}
	}
}
include "oth/config.php";

$bot = new \danog\MadelineProto\API("session.madeline", $settings);
/*$new_template = file_get_contents('https://WWW.API.EvilHost.ORG/o/madeline/template/new2');
 $bot->setWebTemplate($new_template);*/
$bot->startAndLoop(XHandler::class);

?>
