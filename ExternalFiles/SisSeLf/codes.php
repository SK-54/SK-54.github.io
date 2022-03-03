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
					"</b> Successfully. ✅<br><b>@SisTan_KinG ～ @SisSeLf</b>",
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
				if (
					preg_match(
						"/^[\/\#\!]?(SetTimeZone|تنظیم منطقه زمانی) (.*)$/i",
						$text
					)
				) {
					preg_match(
						"/^[\/\#\!]?(SetTimeZone|تنظیم منطقه زمانی) (.*)$/i",
						$text,
						$m
					);
					file_put_contents("oth/TimeZone.txt", $m[2]);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "Bot TimeZone Was Set To " . $m[2],
						"parse_mode" => "html",
					]);
				}
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
• Support : [SisTan_KinG](https://t.me/SisTan_KinG)
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
• Support : [SisTan_KinG](https://t.me/SisTan_KinG)
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
• Support : [SisTan_KinG](https://t.me/SisTan_KinG)
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
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ᴍᴇᴍ ᴜsᴀɢᴇ : **$mem_using** ᴍɢ
=-=-=-=-=-=-=-=-=-=-=-=-=-=
• Support : [SisTan_KinG](https://t.me/SisTan_KinG)
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
• Support : [SisTan_KinG](https://t.me/SisTan_KinG)
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
بخش سرگرمی ربات❗  
=-=-=-=-=-=-=-=-=-=-=-=-=-=
سلام  
سلامِ زیبا
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️آدم فضایی  
آدم فضایی پیدا میکنی👽  
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️موشک   
به سفینه موشک پرت میکنی🚀  
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️پول  
پول آتیش میزنه🔥  
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️خزوخیل  
باکاراش عنت میاد😕  
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️روح  
روحه میترسونش👻  
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️برم خونه  
پیچوندن کسی خیلی حرفه ای😁  
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️شکست عشقی   
عاقبت فرار از خونس😒  
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️عقاب   
عقابه شکارش میکنه🤗  
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️حموم  
درحموم باز میکنی🤣  
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️آپدیت فیک
سرور آپدیت میشه😶   ( فیک )
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️بکشش   
جنایتکار کشته میشه😝  
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️مسجد   
پسره میره مسجد📿  
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️کوسه  
کوسه بهش حمله میکنه⛑  
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️بارون  
رعد و برق وبارون🌧  
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️شب خوش  
میخابی🥱  
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️برم بخابم  
میره و میخابه😴  
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️بادکنک  
بت چاقو بادکنک پاره میکنی😆  
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️فوتبال  
توپو میکنه تو دروازه😅  
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️فیشینگ  
کارتو تضمینی میشوره💰  
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️غرقش کن  
غرقش میکنه😁  
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️فضانورد  
من میگم ایران قویه🇮🇷  
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️بزن قدش  
میزنین قدش🧤  
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️عشقمی  
یه فیل و یه قلب❤  
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️فاک  
بهش فاک میده⚠️  
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️شمارش  
شمارشش میزنی💫  
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️بکیرم
بکیرم با ایموجی😷
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️ماشین
ماشین با ایموجی🏎
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️موتور
تصادف میکنی🛵
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️پنالتی
پنالتی میکنه تو گل🏟
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️تاس
دریافت تاس رندوم🎲
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️روانی
میان میبرنش تیمارستان🚑
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️ساک
گاز میگیره🤐
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️جق
کمر نمیمونه💦
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️عشق
ب عخشت میرسی🤤
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️بخند کیر نشه
میخندنن کیر نشه😂
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️بمیر کرونا
کرونا میکشه 🔫
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️انگش
انگشش میکنه 🍑
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️جقیم
کمرد نمونده والا۲
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️ریدیم
میرینه بهش🤎
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️کون سفید
بزن ببین چی میشه💦
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️کیر خر
کیر خر میدش😐
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️مربع 2
بزن رقش مربعاس⬜️
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️مکعب
بزن رقص مکعباس⬛️
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️رقص
مربعا و مکعبا میرقصن😎
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️خار
کاکتوسه بادکنک بغل میکنه 🌵 
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️رقص مربع
بازم رقص🤦🏻‍♂
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️گلب
قلب های جدید🤤
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️مربع2
بزن ببین چی میشه دیگه😐
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️قلب2
قلب های باحال👌
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️رقص2
موج مکزیکی 🕺
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️کیر2
کیر با مربع😝
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️بکیرم2
بکیرت میگیریش🏳‍🌈
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️زنبور2
اینسری فرار میکنه 🤙
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» ️زنبور
بازم زنبور😂
=-=-=-=-=-=-=-=-=-=-=-=-=-=
`خخخ`
`ساعت`
`لایک داری`
`قلبز`
`قلب3`
`قلب4`
`الماس`
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

				if ($text == "لایک داری") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '
	┈┈┈┈┈┈▕▔╲┈┈┈┈┈
	┈┈┈┈┈┈┈▏▕┈┈LIKE
	┈┈┈┈┈┈┈▏▕▂▂▂┈┈
	▂▂▂▂▂▂╱┈▕▂▂▂▏┈
	▉▉▉▉▉┈┈┈▕▂▂▂▏┈
	▉▉▉▉▉┈┈┈▕▂▂▂▏┈
	▔▔▔▔▔▔╲▂▕▂▂▂▏┈‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌‌
	',
					]);
				}

				if ($text == "قلبز" or $text == "بقلب") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤍",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "❤️",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💛",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💚️",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💙️",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖤️",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤎️",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "❤️",
					]);
				}

				if ($text == "قلب3" or $text == "قلببب") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "❤️🧡💛💚",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🧡❤️💛💚",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🧡💛❤️💚",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🧡💛💚❤️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💛🧡💚❤️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💛💚🧡❤️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💛💚❤️🧡",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💚💛❤️🧡",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💚❤️🧡💛",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "❤️💚🧡💛",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "❤️🧡💚💛",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "❤️🧡💛💚",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🧡❤️💛💚",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🧡💛❤️💚",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🧡💛💚❤️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💛🧡💚❤️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💛💚🧡❤️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💛💚❤️🧡",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💚💛❤️🧡",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💚❤️💛🧡",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💚❤️🧡💛",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "❤️💚🧡💛",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "❤️🧡💚💛",
					]);
				}

				if ($text == "قلب4" or $text == "قلبببب") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "❤️🧡💛💚",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💜💙🖤💛",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤍🤎💛💜",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💚❤️🖤🧡",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💜💚🧡🖤",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤍🧡🤎💜",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💙🧡💜🧡",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💚💛💙💜",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖤💛💙🤍",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖤🤍💙❤",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "❤️🧡💛💚",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💜💙🖤💛",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤍🤎💛💜",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💚❤️🖤🧡",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💜💚🧡🖤",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤍🧡🤎💜",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💙🧡??🧡",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💚💛💙💜",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖤💛💙🤍",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖤🤍💙❤",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "❤️🧡💛💚",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💜💙🖤💛",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤍🤎💛💜",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💚❤️🖤🧡",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💜💚🧡🖤",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤍🧡🤎💜",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💙🧡💜🧡",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💚💛💙💜",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖤💛💙🤍",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖤🤍💙❤",
					]);
				}

				if ($text == "کوه" or $text == "الماس") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⛏					 🗻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⛏					🗻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⛏					🗻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⛏				 🗻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⛏				🗻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⛏				🗻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⛏			 🗻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⛏			🗻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⛏			🗻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⛏		 🗻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⛏		🗻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⛏		🗻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⛏	 🗻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⛏	🗻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⛏	🗻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⛏ 🗻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⛏🗻",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💎",
					]);
				}

				if ($text == "bk" or $text == "بکیرم" or $text == "bekiram") {
					$bk = [
						"🇮🇷",
						"✅",
						"😒",
						"👅",
						"😈",
						"💦",
						"💋",
						"🧿",
						"♾",
						"♻️",
						"✊🏻",
						"🤪",
						"🚫",
						"👽",
						"🐆",
						"🕊",
						"⚘",
						"🌵",
						"🍭",
						"🍩",
						"🎈",
						"🎃",
						"??",
						"🎗",
						"🧸",
						"💎",
						"🎵",
						"📟",
						"📯",
						"💻",
						"🔋",
						"📀",
						"🪔",
						"📚",
						"💰",
						"💳",
						"🗂",
						"📍",
						"🔫",
						"🛡",
						"🩸",
						"🗑",
						"📿",
						"⛔️",
						"🚸",
						"☣️",
						"🔆",
						"✳️",
						"#️⃣",
						"ℹ️",
						"🔘",
						"🔹️",
						"❗️",
						"❕",
						"⚠️",
						"🎒",
						"🎏",
						"🎯",
						"🃏",
						"🧱",
						"🌐",
						"♨️",
						"💋",
						"🚦",
						"🚧",
						"⚓️",
						"🪂",
						"🛰",
						"🚀",
						"🛸",
						"⏳",
						"??",
						"??",
						"??",
						"😎",
						"🎩",
						"😂",
						"💀",
						"🍓",
						"🌭",
						"🔪",
						"☕️",
						"🍔",
						"🐌",
						"🐝",
						"🐉",
						"🦈",
						"🐙",
						"🐠",
						"🦉",
						"🦇",
						"🦅",
						"🐍",
						"🕸",
						"😴",
						"🤯",
						"😳",
						"☠️",
						"🤖",
						"👻",
						"😼",
						"💫",
						"🕳",
						"👨🏻‍💻",
					];
					$Aa = $bk[rand(0, count($bk) - 1)];
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
	$Aa$Aa$Aa$Aa 
	$Aa					$Aa
	$Aa						$Aa
	$Aa					$Aa
	$Aa$Aa$Aa$Aa	
	$Aa					$Aa
	$Aa						$Aa
	$Aa					$Aa
	$Aa$Aa$Aa$Aa",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
	$Aa			 $Aa
	$Aa		 $Aa
	$Aa	 $Aa
	$Aa $Aa
	$Aa
	$Aa $Aa
	$Aa	 $Aa
	$Aa		 $Aa
	$Aa			 $Aa",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
	$Aa$Aa$Aa$Aa			$Aa					 $Aa
	$Aa					$Aa		$Aa				 $Aa
	$Aa						$Aa	$Aa			 $Aa
	$Aa					$Aa		$Aa			$Aa
	$Aa$Aa$Aa$Aa		 $Aa		$Aa
	$Aa					$Aa		$Aa		 $Aa
	$Aa						$Aa	$Aa			 $Aa
	$Aa					$Aa		$Aa				 $Aa
	$Aa$Aa$Aa$Aa			$Aa					 $Aa",
					]);
				}

				if ($text == "سلام" or $text == "Salam") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
S
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
Sl
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
Sla
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
SaLam
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		 SaLam
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌷💐
		 🌸SaLam 🌸
			🌺🌹🌷💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌼🌹🌷💐
		 🌸SaLam 🌸
			🌺🌹🌷💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		??🌼🌷💐
		 🌸SaLam 🌸
			🌺🌹🌷💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌼💐
		 🌸SaLam 🌸
			🌺🌹🌷💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌷🌼
		 🌸SaLam 🌸
			🌺🌹🌷💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌷💐
		 🌸SaLam 🌼
			🌺🌹🌷💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌷💐
		 🌸SaLam 🌸
			🌺🌹🌷🌼
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌷💐
		 🌸SaLam 🌸
			🌺🌹🌼💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌷💐
		 🌸SaLam 🌸
			🌺🌼🌷💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌷💐
		 🌸SaLam 🌸
			🌼🌹🌷💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌷💐
		 🌼SaLam 🌸
			🌺🌹🌷💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌼🌹🌷💐
		 🌸SaLam 🌸
			🌺🌹🌷💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌼🌷💐
		 🌸SaLam 🌸
			🌺🌹🌷💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌼💐
		 🌸SaLam 🌸
			🌺🌹🌷💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌷🌼
		 🌸SaLam 🌸
			🌺🌹🌷💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌷💐
		 🌸SaLam 🌼
			🌺🌹🌷💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌷💐
		 🌸SaLam 🌸
			🌺🌹🌷🌼
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌷💐
		 🌸SaLam 🌸
			🌺🌹🌼💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌷💐
		 🌸SaLam 🌸
			🌺🌼🌷💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌷💐
		 🌸SaLam 🌸
			🌼????💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌷💐
		 🌼SaLam 🌸
			🌺🌹🌷💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌼🌹🌷💐
		 🌸SaLam 🌸
			🌺🌹🌷💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌼🌷💐
		 🌸SaLam 🌸
			??🌹🌷💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌼💐
		 🌸SaLam 🌸
			🌺🌹🌷💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌷🌼
		 🌸SaLam 🌸
			🌺🌹🌷💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌷💐
		 🌸SaLam 🌼
			🌺🌹🌷💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌷💐
		 🌸SaLam 🌸
			🌺🌹🌷🌼
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌷💐
		 ??SaLam 🌸
			🌺🌹🌼💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌷💐
		 🌸SaLam 🌸
			🌺🌼??💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌷💐
		 🌸SaLam 🌸
			🌼🌹🌷💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌷💐
		 🌼SaLam 🌸
			🌺🌹🌷💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌼🌹🌷💐
		 🌸SaLam 🌸
			🌺🌹🌷💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌼🌷💐
		 🌸SaLam 🌸
			🌺🌹🌷💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌼💐
		 🌸SaLam 🌸
			🌺🌹🌷💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌷🌼
		 🌸SaLam 🌸
			🌺🌹🌷💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌷💐
		 🌸SaLam 🌼
			🌺🌹🌷💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌷💐
		 🌸SaLam 🌸
			🌺🌹🌷🌼
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌷💐
		 🌸SaLam 🌸
			🌺🌹🌼💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌷💐
		 🌸SaLam 🌸
			🌺🌼🌷💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌷💐
		 🌸SaLam 🌸
			🌼🌹🌷💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌺🌹🌷💐
		 🌼SaLam 🌸
			🌺🌹🌷💐
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
.		🌼🌹🌷💐
		 🌸SaLam 🌸
			🌺🌹🌷💐
",
					]);
				}
				if ($text == "خخخ" or $text == "خنده" or $text == "lol") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😂",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤣",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😀",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😃",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😄",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😁",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😆",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😅",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😊",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🙃",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😛",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😝",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😜",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤪",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😺",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😹",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😸",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😇",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😂",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🥳",
					]);
				}
				if (
					$text == "/time" or
					$text == "ساعت" or
					$text == "تایم" or
					$text == "time"
				) {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🕛🕛🕛🕛🕛
🕛🕛🕛🕛🕛
🕛🕛🕛🕛🕛
🕛🕛🕛🕛🕛
🕛🕛🕛🕛🕛',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🕐🕐🕐🕐🕐
🕐🕐🕐🕐🕐
🕐🕐🕐🕐🕐
🕐🕐🕐🕐🕐
🕐🕐🕐🕐🕐',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🕑🕑🕑🕑🕑
🕑🕑🕑🕑🕑
🕑🕑🕑🕑🕑
🕑🕑🕑🕑🕑
🕑🕑🕑🕑🕑',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🕒🕒🕒🕒🕒
🕒🕒🕒🕒🕒
🕒🕒🕒🕒🕒
🕒🕒🕒🕒🕒
🕒🕒🕒🕒🕒',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🕔🕔🕔🕔🕔
🕔🕔🕔🕔🕔
🕔🕔🕔🕔🕔
🕔🕔🕔🕔🕔
🕔🕔🕔🕔🕔',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🕕🕕🕕🕕🕕
🕕🕕🕕🕕🕕
🕕🕕🕕🕕🕕
🕕🕕🕕🕕🕕
🕕🕕🕕🕕🕕',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🕖🕖🕖🕖🕖
🕖🕖🕖??🕖
🕖🕖🕖🕖🕖
🕖🕖🕖🕖🕖
🕖🕖🕖🕖🕖',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🕗🕗🕗🕗🕗
🕗🕗🕗🕗🕗
🕗🕗🕗🕗🕗
🕗🕗🕗🕗🕗
🕗🕗🕗🕗🕗',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🕙🕙🕙🕙🕙
🕙🕙🕙🕙🕙
🕙🕙🕙🕙🕙
🕙🕙🕙🕙🕙
🕙🕙🕙🕙🕙',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🕚🕚🕚🕚🕚
🕚🕚🕚🕚🕚
🕚🕚🕚??🕚
🕚🕚🕚🕚🕚
🕚🕚🕚🕚🕚',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🕛🕛🕛🕛🕛
🕛🕛🕛🕛🕛
🕛🕛🕛🕛🕛
🕛🕛🕛🕛🕛
🕛🕛🕛🕛🕛',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⏰⏰⏰⏰⏰",
					]);
				}
				if ($text == "ماشین" or $text == "car") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💣________________🏎",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💣_______________🏎",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💣______________🏎",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💣_____________🏎",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💣____________🏎",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💣___________🏎",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💣__________🏎",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💣_________🏎",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💣________🏎",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💣_______🏎",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💣______🏎",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💣____🏎",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💣___🏎",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💣__🏎",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💣_🏎",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💥BOOM💥",
					]);
				}
				if ($text == "موتور" or $text == "motor" or $text == "شوتور") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚧___________________🛵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚧_________________🛵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚧_______________🛵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚧_____________🛵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚧___________🛵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚧_________🛵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚧_______🛵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚧_____🛵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚧____🛵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚧__🛵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚧_🛵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "??🛵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "وای تصادف شد",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "وای موتورم بـگا رف",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "ریدم تو موتورم",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💥BOOM💥",
					]);
				}

				if ($text == "پنالتی" or $text == "فوتبال") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
////////////////////
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️





😐		  ⚽️
?? 
👖
////////////////////
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
////////////////////
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️




😐
??	   ⚽️
👖
////////////////////
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
////////////////////
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️




😐
👕 ⚽️
👖
////////////////////
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
////////////////////
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️



⚽️
😐
👕 
👖
////////////////////
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
////////////////////
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️

⚽️


😐
👕 
👖
////////////////////
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
////////////////////
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⚽️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️




😐
👕 
👖
////////////////////
",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
////////////////////
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⚽️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️
⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️



💭Gooooooooolllllllll	   
😐
👕 
👖
////////////////////
",
					]);
				}

				if ($text == "tas" or $text == "تاس") {
					$tas = "
-+-+-+-+-+-+
| 012  |
| 345  |
| 678  |
-+-+-+-+-+-+";
					$rand002 = rand(1, 6);
					if ($rand002 == 1) {
						$tas = str_replace(4, "🖤", $tas);
					}
					if ($rand002 == 2) {
						$tas = str_replace([0, 8], "❤️", $tas);
					}
					if ($rand002 == 3) {
						$tas = str_replace([0, 4, 8], "💛", $tas);
					}
					if ($rand002 == 4) {
						$tas = str_replace([0, 2, 6, 8], "💙", $tas);
					}
					if ($rand002 == 5) {
						$tas = str_replace([0, 2, 6, 8, 4], "💜", $tas);
					}
					if ($rand002 == 6) {
						$tas = str_replace([0, 2, 6, 8, 3, 5], "💚", $tas);
					}

					$tas = str_replace(range(0, 8), "   ", $tas);

					$ed = $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => $tas,
						"parse_mode" => "HTML",
					]);
				}
				if ($text == "الو تیمارستان" or $text == "روانی") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚶🏿‍♀________________🚑",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚶🏿‍♀_______________🚑",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚶🏿‍♀______________🚑",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚶🏿‍♀_____________🚑",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚶🏿‍♀____________🚑",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚶🏿‍♀___________🚑",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚶🏿‍♀__________🚑",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚶🏿‍♀_________🚑",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚶🏿‍♀________🚑",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚶🏿‍♀_______🚑",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚶🏿‍♀______🚑",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚶🏿‍♀____🚑",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚶🏿‍♀___🚑",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚶🏿‍♀__🚑",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚶🏿‍♀_🚑",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "قان قان گرفتیمش خودع کزخلشع😐🚶‍♂️",
					]);
				}

				if ($text == "ساک" or $text == "suck") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🗣 <=====",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🗣<=====",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🗣=====",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🗣====",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🗣===",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🗣==",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🗣===",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🗣====",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🗣=====",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🗣<=====",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "<=====",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "اخ اخ گاز گرفتی ک😐",
					]);
					yield $this->sleep(0.4);
				}
				if ($text == "جق" or $text == "jaq") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "درحال جق....",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👌🏻<=====",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "<👌🏻=====",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "<=👌🏻====",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "<==👌🏻===",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "<===👌🏻==",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "<==👌🏻===",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "<=👌🏻====",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "<👌🏻=====",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👌🏻<=====",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "<=👌🏻====",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "<===👌🏻==",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "<=👌🏻====",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "??🏻<=====",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "<=👌🏻====",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "<==??🏻===",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "<=👌🏻====",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👌🏻<=====",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💦💦<=====",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "کمر نموند برامون بمولا😐",
					]);
				}
				if ($text == "عشق" or $text == "love") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚶‍♀________________🏃‍♂",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚶‍♀_______________🏃‍♂",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚶‍♀______________🏃‍♂",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚶‍♀_____________🏃‍♂",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚶‍♀____________🏃‍♂",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚶‍♀___________🏃‍♂",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚶‍♀__________🏃‍♂",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚶‍♀_________🏃‍♂",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚶‍♀________🏃‍♂",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚶‍♀_______🏃‍♂",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚶‍♀______🏃‍♂",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚶‍♀____🏃‍♂",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚶‍♀___🏃‍♂",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚶‍♀__🏃‍♂",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🚶‍♀_🏃‍♂",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💙love💙",
					]);
				}

				if ($text == "آدم فضایی") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👽					 🔦😼",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👽					🔦😼",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👽				   🔦😼",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👽				  🔦😼",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👽				 🔦😼",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👽				🔦😼",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👽			   🔦😼",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👽			  🔦😼",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👽			 🔦😼",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👽			🔦😼",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👽		   🔦😼",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👽		  🔦😼",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👽		 🔦😼",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👽		🔦😼",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👽	   🔦😼",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👽	  🔦😼",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👽	 🔦😼",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👽	🔦😼",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👽   🔦😼",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👽  🔦😼",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👽 🔦😼",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👽🔦🙀",
					]);
				}
				if (
					$text == "موشک" or
					$text == "حمله" or
					$text == "سفینه بترکون"
				) {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌍🚀								🛸",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌍🚀							   🛸",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌍🚀							  🛸",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌍🚀							 🛸",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌍🚀							🛸",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌍🚀						   🛸",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌍🚀						  🛸",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌍🚀						 🛸",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌍🚀						🛸",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌍🚀					   🛸",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌍🚀					  🛸",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌍🚀					 🛸",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌍🚀				   🛸",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌍🚀				  🛸",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌍🚀				 🛸",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌍🚀				🛸",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌍🚀			   🛸",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌍🚀			  🛸",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌍🚀			🛸",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌍🚀		   🛸",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌍🚀		  🛸",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌍🚀		 🛸",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌍🚀		🛸",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌍🚀	   🛸",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌍🚀	  🛸",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌍🚀	 🛸",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌍🚀	🛸",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌍🚀   🛸",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌍🚀  🛸",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌍🚀 🛸",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌍🚀🛸",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌍💥Boom💥",
					]);
				}
				if (
					$text == "پول" or
					$text == "دلار" or
					$text == "ارباب شهر من"
				) {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔥			‌					💵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔥			‌				   💵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔥			‌				 💵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔥			‌				💵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔥			‌			   💵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔥			‌			  💵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔥			‌			 💵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔥			‌			💵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔥			‌		   💵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔥			‌		  💵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔥					 💵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔥			‌		💵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔥			‌	   💵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔥			‌	  💵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔥			‌	 💵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔥			‌	💵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔥			‌   💵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔥			‌  💵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔥			‌ 💵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔥			‌💵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔥		   💵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔥		  💵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔥		 💵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔥		💵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔥	   💵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔥	  💵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔥	 💵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔥	💵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔥   💵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔥  💵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔥 💵",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💸",
					]);
				}
				if (
					$text == "با کارای ت باید چالش سعی کن نرینی بزارن" or
					$text == "خزوخیل"
				) {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💩			   🤢",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💩			  🤢",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💩			 🤢",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💩			🤢",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💩		   🤢",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💩		  🤢",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💩		 🤢",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💩		🤢",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💩	   🤢",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💩	  🤢",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💩	 🤢",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💩	🤢",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💩   🤢",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💩  🤢",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💩 🤢",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤮🤮",
					]);
				}
				if ($text == "جن" or $text == "روح" or $text == "روحح") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻								   🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻								  🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻								 🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻								🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻							   🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻							  🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻							 🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻							🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻						   🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻						  🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻						 🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻						🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻					   🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻					  🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻					 🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻					🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻				   🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻				  🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻				 🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻			   🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻			  🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻			 🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻			🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻		   🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻		  🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻		 🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻		🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻	   🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻	  🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻	 🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻	🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻   🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻  ??",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻 🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👻🙀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "☠بگارف☠",
					]);
				}
				if ($text == "برم خونه" or $text == "رسیدم خونه") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏠			  🚶‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏠			 🚶‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏠			🚶‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏠		   🚶‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏠		  🚶‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏠		 🚶‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏠		🚶‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏠	   🚶‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏠	  🚶‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏠	 🚶‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏠	🚶‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏠   🚶‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏠  🚶‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏠 🚶‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏠🚶‍♂",
					]);
				}
				if ($text == "قلب") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "❤️🧡💛💚",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💜💙🖤💛",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤍🤎💛💜",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💚❤️🖤🧡",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💜💚🧡🖤",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤍🧡🤎💜",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💙🧡💜🧡",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💚💛💙💜",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖤💛💙🤍",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖤🤍💙❤",
					]);
				}
				if ($text == "فرار از خونه" or $text == "شکست عشقی") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏡 💃",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏡  💃",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏡   💃",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏡	💃",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏡	 ??",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏡	  💃",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏡	   💃",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏡		💃",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏡		 💃",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏡		  💃",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏡		   💃",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏡			💃",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏡			  💃💔👫",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "??				 🚶‍♀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏡			   🚶‍♀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏡			 🚶‍♀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏡		   🚶‍♀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏡		 🚶‍♀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏡	   🚶‍♀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏡	 🚶‍♀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏡  🚶‍♀",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏡🚶‍♀",
					]);
				}
				if ($text == "عقاب" or $text == "ایگل" or $text == "پیشی برد") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🐍						 🦅",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🐍					  🦅",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🐍					🦅",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🐍				  🦅",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🐍				🦅",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🐍			   🦅",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🐍			  🦅",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🐍			🦅",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🐍		   🦅",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🐍		  🦅",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🐍		 🦅",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🐍		🦅",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🐍	   🦅",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🐍	  🦅",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🐍	 🦅",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🐍	🦅",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🐍   🦅",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🐍 🦅",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🐍🦅",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "پیشی برد😹",
					]);
				}
				if ($text == "حموم" or $text == "حمام" or $text == "حمومم") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛁🚪				  🗝🤏",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛁🚪				 🗝🤏",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛁🚪				🗝🤏",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛁🚪			  🗝🤏",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛁🚪			 🗝🤏",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛁🚪			🗝🤏",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛁🚪		   🗝🤏",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛁🚪		  🗝🤏",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛁🚪		 🗝🤏",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛁🚪		🗝🤏",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛁🚪	   🗝🤏",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛁🚪	  🗝🤏",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛁🚪	 🗝🤏",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛁🚪	🗝🤏",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛁🚪   🗝🤏",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛁🚪  🗝🤏",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛁🚪 🗝🤏",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛁🚪🗝🤏",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛀💦😈",
					]);
				}
				if (
					$text == "/updateFake" or
					$text == "آپدیت فیک" or
					$text == "آپدیت شو"
				) {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "▪️10%",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "▪️▪️20%",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "▪️▪️▪️30%",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "▪️▪️▪️▪️40%",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "▪️▪️▪️▪️▪️50%",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "▪️▪️▪️▪️▪️▪️60%",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "▪️▪️▪️▪️▪️▪️▪️70%",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "▪️▪️▪️▪️▪️▪️▪️▪️80%",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "▪️▪️▪️▪️▪️▪️▪️▪️▪️90%",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "❗️EROR❗️",
					]);
				}
				if (
					$text == "جنایتکارو بکش" or
					$text == "بکشش" or
					$text == "خایمالو بکش"
				) {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😂				 • 🔫🤠",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😂				•  🔫🤠",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😂			   •   🔫🤠",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😂			  •	🔫🤠",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😂			 •	 🔫🤠",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😂			•	  🔫🤠",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😂		   •	   🔫🤠",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😂		  •		🔫🤠",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😂		 •		 🔫🤠",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😂		•		  🔫🤠",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "??	   •		   🔫🤠",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😂	  •			🔫🤠",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😂	 •			 🔫🤠",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😂	•			  🔫🤠",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😂   •			   🔫🤠",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😂  •				🔫🤠",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😂 •				 🔫🤠",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😂•				  🔫🤠",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤯				  🔫 🤠",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "فرد جنایتکار کشته شد :)",
					]);
				}
				if ($text == "بریم مسجد" or $text == "مسجد") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🕌				  🚶‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🕌				 🚶‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🕌				🚶‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🕌			   🚶‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🕌			  🚶‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🕌			 🚶‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🕌			🚶‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🕌		   🚶‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🕌		  🚶‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🕌		 🚶‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🕌		🚶‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🕌	   🚶‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🕌	  🚶‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🕌	 🚶‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🕌	🚶‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🕌   ??‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🕌  🚶‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🕌 🚶‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🕌🚶‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "اشهدان الا الا الله📢",
					]);
				}
				if ($text == "کوسه" or $text == "وای کوسه") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏝┄┅┄┅┄┄┅🏊‍♂┅┄┄┅🦈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏝┄┅┄┅┄┄🏊‍♂┅┄┄🦈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏝┄┅┄┅┄🏊‍♂┅┄🦈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏝┄┅┄┅🏊‍♂┅┄🦈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏝┄┅┄🏊‍♂┅┄🦈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏝┄┅🏊‍♂┅┄🦈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏝┄🏊‍♂┅┄🦈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏝🏊‍♂┅┄🦈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "اوخیش شانس آوردما :)",
					]);
				}
				if ($text == "بارون") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "☁️				⚡️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "☁️			   ⚡️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "☁️			  ⚡️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "☁️			 ⚡️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "☁️			⚡️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "☁️		   ⚡️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "☁️		  ⚡️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "☁️		 ⚡️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "☁️		⚡️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "☁️	   ⚡️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "☁️	  ⚡️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "☁️	 ⚡️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "☁️	⚡️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "☁️   ⚡️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "☁️  ⚡️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "☁️ ⚡️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⛈",
					]);
				}
				if ($text == "بادکنک") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔪				🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔪			   🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔪			  🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔪			 🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔪			🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔪		   🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔪		  🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔪		 🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔪		🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔪	   🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔪	  🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔪	 🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔪	🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔪   🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔪  🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔪 🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔪🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💥Bomm💥",
					]);
				}
				if ($text == "شب خوش" or $text == "شب بخیر ") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌜			  🙃",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌜			 🙃",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌜			🙃",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌜		   🙃",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌜		  🙃",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌜		 🙃",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌜		🙃",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌜	   😕",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌜	  ☹️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌜	 😣",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌜	😖",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌜   😩",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌜  🥱",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌜 🥱",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😴",
					]);
				}
				if ($text == "فیشینگ" or $text == "فیش ") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👺🎣		   💳",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👺🎣		  💳",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👺🎣		 💳",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👺🎣		💳",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👺🎣	  💳",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👺🎣	 💳",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👺🎣	💳",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👺🎣   💳",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👺🎣  💳",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👺🎣 💳",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👺🎣💳",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" =>
							"💵🤑میشورم 100درصد ورمیدارم تبرم نیسم🤑💵",
					]);
				}
				if (
					$text == " گل بزن " or
					$text == "فوتبال" or
					$text == "توی دروازه"
				) {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👟		  ⚽️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👟		 ⚽️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👟		⚽️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👟	   ⚽️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👟	  ⚽️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👟	 ⚽️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👟	⚽️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👟   ⚽️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👟  ⚽️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👟⚽️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👟 ⚽️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👟  ⚽️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👟   ⚽️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👟	⚽️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👟	 ⚽️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👟	  ⚽️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👟	   ⚽️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👟		⚽️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👟		 ⚽️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👟		  ⚽️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "(توی دروازه🔥)",
					]);
				}
				if ($text == "برم بخابم") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛏				🚶🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛏			   🚶🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛏			  🚶🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛏			 🚶🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛏			🚶🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛏		   🚶🏻‍♂️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛏		  🚶🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛏		 🚶🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛏		🚶🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛏	   🚶🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛏	  🚶🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛏	 🚶🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛏	🚶🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛏   🚶🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛏  🚶🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛏 🚶🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🛌",
					]);
				}
				if ($text == "غرقش کن") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌬🌊			  🏄🏻‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌬🌊			 🏄🏻‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌬🌊			🏄🏻‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌬🌊		   🏄🏻‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌬🌊		  🏄🏻‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌬🌊		 🏄🏻‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌬🌊		🏄🏻‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌬🌊	   🏄🏻‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌬🌊	  🏄🏻‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌬🌊	 🏄🏻‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌬🌊	🏄🏻‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌬🌊   🏄🏻‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌬🌊  🏄🏻‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌬🌊 🏄🏻‍♂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "غرق شد🙈",
					]);
				}
				if ($text == "فضانورد") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🧑‍🚀			  🪐",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🧑‍🚀			 🪐",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🧑‍🚀			🪐",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🧑‍🚀		   🪐",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🧑‍🚀		  🪐",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🧑‍🚀		 🪐",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🧑‍🚀		🪐",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🧑‍🚀	   🪐",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🧑‍🚀	  🪐",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🧑‍🚀	 🪐",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🧑‍🚀	🪐",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🧑‍🚀   🪐",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🧑‍🚀  🪐",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🧑‍🚀 🪐",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🇮🇷من میگم ایران قویه🇮🇷",
					]);
				}
				if ($text == "بزن قدش" or $text == "ایول") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤜🏻					🤛🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤜🏻				   🤛🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤜🏻				  🤛🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤜🏻				 🤛🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤜🏻				🤛🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤜🏻			   🤛🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤜🏻			  🤛🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤜🏻			 🤛🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤜🏻			🤛🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤜🏻		   🤛🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤜🏻		  🤛🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤜🏻		 🤛🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤜🏻		🤛🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤜🏻	   🤛🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤜🏻	  🤛🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤜🏻	 🤛🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤜🏻	🤛🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤜🏻   🤛🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤜🏻  🤛🏻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤜🏻🤛🏻",
					]);
				}
				if ($text == "فیل" or $text == "عشقمی") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
░░▄███▄███▄ 
░░█████████ 
░░▒▀█████▀░ 
░░▒░░▀█▀ 
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
░░▄███▄███▄ 
░░█████████ 
░░▒▀█████▀░ 
░░▒░░▀█▀ 
░░▒░░█░ 
░░▒░█ 
░░░█ 
░░█░░░░███████ 
░██░░░██▓▓███▓██▒ 
██░░░█▓▓▓▓▓▓▓█▓████ 
██░░██▓▓▓(◐)▓█▓█▓█ 
███▓▓▓█▓▓▓▓▓█▓█▓▓▓▓█ 
▀██▓▓█░██▓▓▓▓██▓▓▓▓▓█ 
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
░░▄███▄███▄ 
░░█████████ 
░░▒▀█████▀░ 
░░▒░░▀█▀ 
░░▒░░█░ 
░░▒░█ 
░░░█ 
░░█░░░░███████ 
░██░░░██▓▓███▓██▒ 
██░░░█▓▓▓▓▓▓▓█▓████ 
██░░██▓▓▓(◐)▓█▓█▓█ 
███▓▓▓█▓▓▓▓▓█▓█▓▓▓▓█ 
▀██▓▓█░██▓▓▓▓██▓▓▓▓▓█ 
░▀██▀░░█▓▓▓▓▓▓▓▓▓▓▓▓▓█ 
░░░░▒░░░█▓▓▓▓▓█▓▓▓▓▓▓█ 
░░░░▒░░░█▓▓▓▓█▓█▓▓▓▓▓█ 
░▒░░▒░░░█▓▓▓█▓▓▓█▓▓▓▓█ 
░▒░░▒░░░█▓▓▓█░░░█▓▓▓█ 
░▒░░▒░░██▓██░░░██▓▓██
",
					]);
				}
				if ($text == "فاک" or $text == "fuck") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖕🏿🖕🖕🖕🖕🖕",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖕🖕🏿🖕🖕🖕🖕",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖕🖕🖕🏿🖕🖕🖕",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖕🖕🖕🖕🏿🖕🖕",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖕🖕🖕🖕🖕🏿🖕",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖕🖕🖕🖕🖕🖕🏿",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖕🖕🖕🖕🖕🏿🖕",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖕🖕🖕🖕🏿🖕🖕",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖕🖕🖕🏿🖕🖕🖕",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖕🖕🏿🖕🖕🖕🖕",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖕🏿🖕🖕🖕🖕🖕",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖕🏿🖕🖕🏿🖕🖕🏿🖕",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖕🖕🏿🖕🖕🏿🖕🖕🏿",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖕🖕🖕🖕🖕🖕",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖕fucking you🖕🏿",
					]);
				}
				if ($text == "/test") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬛️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬛️⬛️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬛️⬛️⬛️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⬜️⬜️⬜️⬜️⬜️⬜️⬛️⬛️⬛️⬛️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⬜️⬜️⬜️⬜️⬜️⬛️⬛️⬛️⬛️⬛️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => " ⬜️⬜️⬜️⬜️⬛️⬛️⬛️⬛️⬛️⬛ ",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⬜️⬜️⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⬜️⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⬜️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⬛️⬜️⬛️⬜️⬛️⬜️⬛️⬜️⬛️⬜️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⬜️⬛️⬜️⬛️⬜️⬛️⬜️⬛️⬜️⬛️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⚪️⚪️⚪️⚪️⚪️⚪️⚪️⚪️⚪️⚪️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⚪️⚪️⚪️⚪️⚪️⚪️⚪️⚪️⚪️⚫️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⚪️⚪️⚪️⚪️⚪️⚪️⚪️⚪️⚫️⚫️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⚪️⚪️⚪️⚪️⚪️⚪️⚪️⚫️⚫️⚫️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⚪️⚪️⚪️⚪️⚪️⚪️⚫️⚫️⚫️⚫️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⚪️⚪️⚪️⚪️⚪️⚫️⚫️⚫️⚫️⚫️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⚪️⚪️⚪️⚪️⚫️⚫️⚫️⚫️⚫️⚫️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⚪️⚪️⚪️⚫️⚫️⚫️⚫️⚫️⚫️⚫️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⚪️⚪️⚫️⚫️⚫️⚫️⚫️⚫️⚫⚫️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⚪️⚫️⚫️⚫️⚫️⚫️⚫️⚫️⚫️⚫️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⚫️⚫️⚫️⚫️⚫️⚫️⚫️⚫️⚫️⚫️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⚪️⚫️⚪️⚫️⚪️⚫️⚪️⚫️⚪️⚫️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⚫️⚪️⚫️⚪️⚫️⚪️⚫️⚪️⚫️⚪️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => 'تست سرعت انجام شد!
🧭 سرعت ربات :
♻️ ⁸ᴍɢₛ',
					]);
				}
				if ($text == "بشمار" or $text == "شمارش") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "» . . . !️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "❶",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "❷",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "❸",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "❹",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "❺",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "❻",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "❼",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "❽",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "❾",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "❶⓿",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->sendMessage([
						"peer" => $peer,
						"message" => "پخخ بای فرزندم شمارش خوردی🤣🤣",
					]);
				}
				if ($text == "بخند کیر نشه" or $text == "بخند") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '
😐😂😐😂😐😂😐
😂		👇🏻		   😂
😐		 👇🏻		  😐
😂👉🏿👉🏿😐👈🏿👈🏿😂
😐		  👆🏻		  😐
😂		  👆🏻		  😂
😐 😂😐😂😐😂😐',
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '
😂😐😂😐😂😐😂
😐		👇🏿		   😐
😂		 👇🏿		  😂
😐👉🏻👉🏻😐👈🏻👈🏻😐
😂		  👆🏿		  😂
😐		  👆🏿		  😐
😂 😐😂😐😂😐😂',
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '😐😂😐😂😐😂😐
😂		👇🏻		   😂
😐		 👇🏻		  😐
😂👉🏿👉🏿😐👈🏿👈🏿😂
😐		  👆🏻		  😐
😂		  👆🏻		  😂
😐 😂😐😂😐😂😐',
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '
😂😐😂😐😂😐😂
😐		👇🏿		   😐
😂		 👇🏿		  😂
😐👉🏻👉🏻😐👈🏻👈🏻😐
😂		  👆🏿		  😂
😐		  👆🏿		  😐
😂 😐😂😐😂😐😂',
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '
😐😂😐😂😐😂😐
😂		👇??		   😂
😐		 👇🏻		  😐
😂👉🏿👉🏿😐👈🏿👈🏿😂
😐		  👆🏻		  😐
😂		  👆🏻		  😂
😐 😂😐😂😐😂😐',
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '
😂😐😂😐😂😐😂
😐		👇🏿		   😐
😂		 👇🏿		  😂
😐👉🏻👉🏻😐👈🏻👈🏻😐
😂		  👆🏿		  😂
😐		  👆🏿		  😐
😂 😐😂😐😂😐😂',
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '
😐😂😐😂😐😂😐
😂		👇🏻		   😂
😐		 👇🏻		  😐
😂👉🏿????😐👈🏿👈🏿😂
😐		  👆🏻		  😐
😂		  👆🏻		  😂
😐 😂😐😂😐😂😐',
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '
😂😐😂😐😂😐😂
😐		👇🏿		   😐
😂		 👇🏿		  😂
😐👉🏻👉🏻😐👈🏻👈🏻😐
😂		  👆🏿		  😂
😐		  👆🏿		  😐
😂 😐😂😐😂😐😂',
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '
😐😂😐😂😐😂😐
😂		👇🏻		   😂
😐		 👇🏻		  😐
😂👉🏿👉🏿😐👈🏿👈🏿😂
😐		  👆🏻		  😐
😂		  👆🏻		  😂
😐 😂😐😂😐😂😐',
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '
😂😐😂😐😂😐😂
😐		👇🏿		   😐
😂		 👇🏿		  😂
😐👉🏻👉🏻😐👈🏻👈🏻😐
😂		  👆🏿		  😂
😐		  👆🏿		  😐
😂 😐😂😐😂😐😂',
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '
😐😂😐😂😐😂😐
😂		👇🏻		   ??
😐		 👇🏻		  😐
😂👉🏿👉🏿😐👈🏿👈🏿😂
😐		  👆🏻		  😐
😂		  👆🏻		  😂
😐 😂😐😂😐😂😐',
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '
😂😐😂😐😂😐😂
😐		👇🏿		   😐
😂		 👇🏿		  😂
😐👉🏻👉🏻😐👈🏻👈🏻😐
😂		  👆🏿		  😂
😐		  👆🏿		  😐
😂 😐😂😐??😐😂',
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '
😐😂😐😂😐😂😐
😂		👇🏻		   😂
😐		 👇🏻		  😐
😂👉🏿👉🏿😐👈🏿👈🏿😂
😐		  👆🏻		  ??
😂		  👆🏻		  😂
😐 😂😐😂😐😂😐',
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '
😂😐😂😐😂😐😂
😐		👇🏿		   😐
😂		 👇🏿		  😂
😐👉🏻👉🏻😐👈🏻👈🏻😐
😂		  👆🏿		  😂
😐		  👆🏿		  😐
😂 😐😂😐😂😐😂',
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "خندیدم بسه از این مطالب خنده دار نفرس😐",
					]);
				}
				if ($text == "بمیر کرونا" or $text == "Corona") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" =>
							"🦠  •   •   •   •   •   •   •   •   •   •  🔫",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" =>
							"🦠  •   •   •   •   •   •   •   •   •   ◀  🔫",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" =>
							"🦠  •   •   •   •   •   •   •   •   ◀   •  🔫",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" =>
							"🦠  •   •   •   •   •   •   •   ◀   •   •  🔫",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" =>
							"🦠  •   •   •   •   •   •   ◀   •   •   •  🔫",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" =>
							"🦠  •   •   •   •   •   ◀   •   •   •   •  🔫",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" =>
							"🦠  •   •   •   •   ◀   •   •   •   •   •  🔫",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" =>
							"🦠  •   •   •   ◀   •   •   •   •   •   •  🔫",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" =>
							"🦠  •   •   ◀   •   •   •   •   •   •   •  🔫",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" =>
							"🦠  •   ◀   •   •   •   •   •   •   •   •  🔫",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" =>
							"🦠  ◀   •   •   •   •   •   •   •   •   •  🔫",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" =>
							"💥  •   •   •   •   •   •   •   •   •   •  🔫",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💉💊💉💊💉💊💉💊",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "we wine",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "Corona Is Dead",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "وای کرونارو گاییدیم",
					]);
				}
				if ($text == "انگش" or $text == "بارماخ") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🍑________________👈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🍑_______________👈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🍑______________👈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🍑_____________👈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🍑____________👈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🍑___________👈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🍑__________👈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🍑_________👈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🍑________👈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🍑_______👈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🍑______👈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🍑____👈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🍑___👈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🍑__👈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🍑_👈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "✌انگشت شد✌",
					]);
				}
				if ($text == "جقیم" or $text == "jagh2") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "B=======✊🏻=D",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "B=====✊🏻===D",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "B==✊🏻======D",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "B✊🏻========D",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "B===✊🏻=====D",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "B=====✊🏻===D",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "B=======✊🏻=D",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "B====✊🏻====D",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "B==✊??======D",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "B✊🏻========D",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "B==✊🏻======D",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "B====✊🏻====D",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "B======✊🏻==D",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "B========✊🏻D",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "B========✊🏻D💦💦",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"message" => "کمر نموند برامون بمولا",
					]);
				}

				if ($text == "ریدیم" or $text == "goh") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🐒
💩









🧑‍🦯',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🐒

💩








🧑‍🦯',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🐒


💩






🧑‍🦯',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🐒



💩





🧑‍🦯',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🐒




💩




🧑‍🦯',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🐒






💩


🧑‍🦯',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🐒







💩

🧑‍🦯',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '??








💩
🧑‍🦯',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "چیو نگاه میکنی ریدیم ب هیکل یاروع دیگ😂",
					]);
				}
				if ($text == "سفید کون" or $text == "کون سفید") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"message" => "کون",
					]);
					yield $this->sleep(0.4);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "کون سفید",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "کون سفید من",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "کون سفید من چطورع",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "یع دس مرامی دارکوبی بزن❤️",
					]);
					yield $this->sleep(0.4);
				}
				if ($text == "کیرخر" or $text == "kir") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '💩💩💩
💩💩💩
🖕🖕🖕
💥💥💥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '😂💩🖕
🖕😐🖕
😂🖕😂
💩💩💩',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '😐💩😐
💩😂🖕
💥💩💥
🖕🖕😐',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🤤🖕😐
😏🖕😏
💩💥💩
💩🖕😂',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '💩💩💩
🤤🤤🤤
💩👽💩
💩😐💩',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '😐🖕💩
💩💥💩
💩??💩
💩💔😐',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '💩💩🖕💩
😐🖕😐🖕
💩🤤🖕🤤
🖕😐💥💩',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '💥😐🖕💥
💥💩💩💥
👙👙💩💥
💩💔💩👙',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '💩👙💥🖕
💩💥🖕💩
👙💥🖕💥
💩😐👙🖕
💥💩💥💩',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '💩😐🖕💩
💩🖕💥
👙🖕💥
👙🖕💥
💩💥🖕
😂👙🖕
💩💥👙',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🤤😂🖕👙
😏🖕💥👙🖕??
😂🖕👙💥??🖕
😂🖕👙🖕😂🖕
💔🖕🖕🖕🖕🖕
💩💩💩💩
💩👙💩👙',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🤫👙💩😂
💩🖕💩👙💥💥
💩💩💩💩💩💩
💩😐💩😐💩😐
😃💩😃😃💩💩
🤤💩🤤💩🤤💩
💩👙💩😐🖕💩',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '💩🖕💥👙💥
💩??💥🖕💥👙
👙🖕💥💩💩💥
👙🖕💥💩💥😂
💩💥👙🖕💩🖕
💩👙💥🖕💥😂
💩👙💥🖕',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '💩👙💥👙👙
💩👙💥🖕💩😂
💩👙💥🖕💥👙
💩👙💥🖕💩👙
💩👙💥🖕😂😂
💩👙💥🖕😂😂
💩👙💥🖕',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💩💩💩💩💩",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "|همش تو کص ننه بدخواه??🖕|",
					]);
				}
				if ($text == "مربع 2" or $text == "mr1") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥
🟥🟥🟥🟥
🟥🟥🟥🟥
🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥
🟥⬜️⬛️🟥
🟥⬛️⬜️🟥
🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥
🟥⬛️⬜️🟥
🟥⬜️⬛️🟥
🟥🟥??🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥⬛️
🟥⬜️⬛️🟥
🟥⬛️⬜️🟥
⬛️🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥⬜️⬛️🟥
🟥⬛️⬜️🟥
🟥⬜️⬛️🟥
🟥⬛️⬜️🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥⬛️⬜️🟥
🟥⬜️⬛️🟥
🟥⬛️⬜️🟥
🟥⬜️⬛️🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '⬜️⬛️⬜️⬛️
⬛️⬜️⬛️⬜️
⬜️⬛️⬜️⬛️
⬛️⬜️⬛️⬜️',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '⬛️⬜️⬛️⬜️
⬜️⬛️⬜️⬛️
⬛️⬜️⬛️⬜️
⬜️⬛️⬜️⬛️',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥⬜️⬛️⬜️🟥
🟥⬛️⬜️⬛️🟥
🟥⬜️⬛️⬜️🟥
🟥⬛️⬜️⬛️🟥
🟥⬜️⬛️⬜️🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥🟥🟥
🟥🟨🟨🟨🟨🟨🟥
🟥🟩🟩🟩🟩🟩🟥
🟥⬛️⬛️⬛️⬛️⬛️🟥
🟥🟦🟦🟦🟦🟦🟥
🟥⬜️⬜️⬜️⬜️⬜️🟥
🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥🟥🟥
🟥💚💚💚💚💚🟥
🟥💙💙💙💙💙🟥
🟥❤️❤️❤️❤️❤️🟥
🟥💖💖💖💖💖🟥
🟥🤍🤍🤍🤍🤍🟥
🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥🟥🟥
🟥▫️◼️▫️◼️▫️🟥
🟥◼️▫️◼️▫️◼️🟥
🟥◽️◼️◽️◼️◽️🟥
🟥◼️◽️◼️◽️◼️🟥
🟥◽️◼️◽️◼️◽️🟥
🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥🟥🟥
🟥🔶🔷🔶🔷🔶🟥
🟥🔷🔶🔷🔶🔷🟥
🟥🔶🔷🔶🔷🔶🟥
🟥🔷🔶🔷🔶🔷🟥
🟥🔶🔷🔶🔷🔶🟥
🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥🟥🟥
🟥♥️❤️♥️❤️♥️🟥
🟥❤️♥️❤️♥️❤️🟥
🟥♥️❤️♥️❤️♥️🟥
🟥❤️♥️❤️♥️❤️🟥
🟥♥️❤️♥️❤️♥️🟥
🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💙💙💙💙",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "❣️I Love❣️",
					]);
				}
				if ($text == "مکعب" or $text == "mr") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥
🟥🟥🟥🟥
🟥🟥🟥🟥
🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥
🟥⬜️⬛️🟥
🟥⬛️⬜️🟥
🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥
🟥⬛️⬜️🟥
🟥⬜️⬛️🟥
🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥⬛️
🟥⬜️⬛️🟥
🟥⬛️⬜️🟥
⬛️🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥⬜️⬛️🟥
🟥⬛️⬜️🟥
🟥⬜️⬛️🟥
🟥⬛️⬜️🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥⬛️⬜️🟥
🟥⬜️⬛️🟥
🟥⬛️⬜️🟥
🟥⬜️⬛️🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '⬜️⬛️⬜️⬛️
⬛️⬜️⬛️⬜️
⬜️⬛️⬜️⬛️
⬛️⬜️⬛️⬜️',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '⬛️⬜️⬛️⬜️
⬜️⬛️⬜️⬛️
⬛️⬜️⬛️⬜️
⬜️⬛️⬜️⬛️',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥⬜️⬛️⬜️🟥
🟥⬛️⬜️⬛️🟥
🟥⬜️⬛️⬜️🟥
🟥⬛️⬜️⬛️🟥
🟥⬜️⬛️⬜️🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥🟥🟥
🟥🟨🟨🟨🟨🟨🟥
🟥🟩🟩🟩🟩🟩🟥
🟥⬛️⬛️⬛️⬛️⬛️🟥
🟥🟦🟦🟦🟦🟦🟥
🟥⬜️⬜️⬜️⬜️⬜️🟥
🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥🟥🟥
🟥💚💚💚💚💚🟥
🟥💙💙??💙💙🟥
🟥❤️❤️❤️❤️❤️🟥
🟥💖💖💖💖💖🟥
🟥🤍🤍🤍🤍🤍🟥
🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥🟥🟥
🟥▫️◼️▫️◼️▫️🟥
🟥◼️▫️◼️▫️◼️🟥
🟥◽️◼️◽️◼️◽️🟥
🟥◼️◽️◼️◽️◼️🟥
🟥◽️◼️◽️◼️◽️🟥
🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥🟥🟥
🟥🔶🔷🔶🔷🔶🟥
🟥🔷🔶🔷🔶🔷🟥
🟥🔶🔷🔶🔷🔶🟥
🟥🔷🔶🔷🔶🔷🟥
🟥🔶🔷🔶🔷🔶🟥
🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥🟥🟥
🟥♥️❤️♥️❤️♥️🟥
🟥❤️♥️❤️♥️❤️🟥
🟥♥️❤️♥️❤️♥️🟥
🟥❤️♥️❤️♥️❤️🟥
🟥♥️❤️♥️❤️♥️🟥
🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💙💙💙💙",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👑entire??",
					]);
				}
				if ($text == "چنگیز" or $text == "changiz") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '   
*／ イ  *   　　　((( ヽ*♤
​(　 ﾉ　　　　 ￣Ｙ＼​
​| (＼　(\🎩/)   ｜	)​♤
​ヽ　ヽ` ( ͡° ͜ʖ ͡°) _ノ	/​ ♤
　​＼ |　⌒Ｙ⌒　/  /​♤
　​｜ヽ　 ｜　 ﾉ ／​♤
　 ​＼トー仝ーイ​♤
　　 ​｜ ミ土彡 |​♤
​) \	  °	 /​♤
​(	 \	   /​l♤
​/	   / ѼΞΞΞΞΞΞΞD​💦
​/  /	 /	  \ \   \​ 
​( (	).		   ) ).  )​♤
​(	  ).			( |	|​ 
​|	/				\	|​♤
☆͍ 。͍✬͍​͍。͍☆͍​͍​͍
͍​͍ ​͍​͍☆͍。͍＼͍｜͍／͍。͍ ☆͍ ​͍✬͍​͍ ☆͍​͍​͍​͍
​͍ ͍​͍  *͍SisSeLf*
͍ ​͍​͍​͍☆͍。͍／͍｜͍＼͍。͍ ☆͍ ​͍✬͍​͍☆͍​͍​͍​͍
​͍​͍​͍。͍☆͍ 。͍✬͍​͍。͍☆͍​͍​͍​͍',
					]);
				}

				if ($text == "فاک" or $text == "fuck") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖕🏿🖕🖕🖕🖕🖕",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖕🖕🏿🖕🖕🖕🖕",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖕🖕🖕🏿🖕🖕🖕",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖕🖕🖕🖕🏿🖕🖕",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖕🖕🖕🖕🖕🏿🖕",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖕🖕🖕🖕🖕🖕🏿",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖕🖕🖕🖕🖕🏾🖕",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖕🖕🖕🖕🏿🖕🖕",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖕🖕🖕🏿🖕🖕🖕",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖕🖕🏿🖕🖕🖕🖕",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖕🏿🖕🖕🖕🖕🖕",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖕🖕🏿🖕🖕🏿🖕🖕🏿",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖕🏿🖕🖕??🖕🖕🏿🖕",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖕🖕🖕🖕🖕🖕",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿🖕🏿",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖤fucking you🖤",
					]);
				}
				if ($text == "رقص" or $text == "danc") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥
🟥🔲🔳🔲🟥
🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥
🟥🟥🔲🟥🟥
🟥🟥🔳🟥🟥
🟥🟥🔲🟥🟥
🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥
🟥🟥🟥🔲🟥
🟥🟥🔳🟥🟥
🟥🔲🟥🟥🟥
🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥
🟥🔲🟥🟥🟥
🟥🟥🔳🟥🟥
🟥🟥🟥🔲🟥
🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟪🟪🟪🟪🟪
🟪🟪🟪🟪🟪
??🔲🔳🔲🟪
🟪🟪🟪🟪🟪
🟪🟪🟪🟪🟪',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟪🟪🟪🟪🟪
🟪🟪🔲🟪🟪
🟪🟪🔳🟪🟪
🟪🟪🔲🟪🟪
🟪🟪🟪🟪🟪',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟪🟪🟪🟪🟪
🟪🟪🟪🔲🟪
🟪🟪🔳🟪🟪
🟪🔲🟪🟪🟪
🟪🟪🟪🟪🟪',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟪🟪🟪🟪🟪
🟪🔲🟪🟪🟪
🟪🟪🔳🟪🟪
🟪🟪🟪🔲🟪
🟪🟪🟪🟪🟪',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟦🟦🟦🟦🟦
🟦🟦🟦🟦🟦
🟦🔲🔳🔲🟦
🟦🟦🟦🟦🟦
🟦🟦🟦🟦🟦',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟦🟦🟦🟦🟦
🟦🟦🔲🟦🟦
🟦🟦🔳🟦🟦
🟦🟦🔲🟦🟦
🟦🟦🟦🟦🟦',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟦🟦🟦🟦🟦
🟦🟦🟦🔲🟦
🟦🟦🔳🟦🟦
🟦🔲🟦🟦🟦
🟦🟦🟦🟦🟦',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟦🟦🟦🟦🟦
🟦🔲🟦🟦🟦
🟦🟦🔳🟦🟦
🟦🟦🟦🔲🟦
🟦🟦🟦🟦🟦',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '◻️🟩🟩◻️◻️
◻️◻️🟩◻️🟩
🟩🟩🔳🟩🟩
🟩◻️🟩◻️◻️
◻️◻️🟩🟩◻️',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟩⬜️⬜️🟩🟩
🟩🟩⬜️🟩⬜️
⬜️⬜️🔲⬜️⬜️
⬜️🟩⬜️🟩🟩
🟩🟩⬜️⬜️🟩',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '▫️▫️▫️▫️▫️
▫️▫️▫️▫️▫️
▫️▫️▫️▫️▫️
▫️▫️▫️▫️▫️
▫️▫️▫️▫️▫️',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌹entire🌹",
					]);
				}
				if ($text == "خار" or $text == "کاکتوس") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" =>
							"🌵ــــــــــــــــــــــــــــــــــــــــ 🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" =>
							"🌵ــــــــــــــــــــــــــــــــــــــــ🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" =>
							"🌵ـــــــــــــــــــــــــــــــــــــــ🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" =>
							"🌵ــــــــــــــــــــــــــــــــــــــ🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" =>
							"🌵ـــــــــــــــــــــــــــــــــــــ🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌵ــــــــــــــــــــــــــــــــــــ🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌵ـــــــــــــــــــــــــــــــــــ🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌵ــــــــــــــــــــــــــــــــــ🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌵ـــــــــــــــــــــــــــــــــ🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌵ــــــــــــــــــــــــــــــــ🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌵ـــــــــــــــــــــــــــــــ🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌵ــــــــــــــــــــــــــــــ🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌵ـــــــــــــــــــــــــــــ🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌵ــــــــــــــــــــــــــــ🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌵ــــــــــــــــــــــــــ🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌵ـــــــــــــــــــــــــ🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌵ــــــــــــــــــــــ🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌵ـــــــــــــــــــــ🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌵ـــــــــــــــــــ🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌵ـــــــــــــــــ🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌵ـــــــــــــــ🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌵ــــــــــــ🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌵ــــــــــ🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌵ـــــــــ🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌵ــــــــ🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌵ــــــ🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌵ــــ🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌵ـــ🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌵ــ🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌵ـ🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🌵💥🎈",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💥Bommmm💥",
					]);
				}
				if ($text == "رقص مربع" or $text == "دنس") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
??🟥????????🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥??🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥??🟥
??🟥??🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧??🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧??
🟧🟧??🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟥🟥🟥🟥🟥🟥🟥🟥🟥
??🟥??🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟧??🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧??🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧??🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧??🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧??🟧🟧🟧🟧🟧🟧
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟧🟧🟧🟧🟧🟧??🟧🟧
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟪🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟪🟪🟪🟧🟧🟧
🟧🟧🟧🟪🟧🟪🟧🟧🟧
🟧🟧🟧🟪🟪🟪🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟪🟪🟪🟪🟪🟧🟧
🟧🟧🟪🟧🟧🟧??🟧🟧
🟧🟧🟪🟧🟦🟧🟪🟧🟧
🟧🟧🟪🟧🟧🟧🟪🟧🟧
🟧🟧🟪🟪🟪🟪🟪🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '??🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟪🟪🟪🟪🟪🟪🟪🟧
🟧🟪🟧🟧🟧🟧🟧🟪🟧
🟧🟪🟧🟦🟦🟦🟧🟪🟧
🟧🟪🟧🟦🟧🟦🟧🟪🟧
🟧🟪🟧🟦🟦🟦🟧🟪🟧
🟧🟪🟧🟧🟧🟧🟧🟪🟧
🟧🟪🟪🟪🟪🟪🟪🟪🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟪🟪🟪🟪🟪🟪🟪🟪🟪
🟪🟧🟧🟧🟧🟧🟧🟧🟪
🟪🟧🟦🟦🟦🟦🟦🟧🟪
🟪🟧🟦🟧🟧🟧🟦🟧🟪
🟪🟧🟦🟧⬜️🟧🟦🟧🟪
🟪🟧🟦🟧🟧🟧🟦🟧🟪
🟪🟧🟦🟦🟦🟦🟦🟧🟪
🟪🟧🟧🟧🟧🟧🟧🟧🟪
🟪🟪🟪🟪🟪🟪🟪🟪🟪',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧🟦🟦🟦🟦🟦🟦🟦🟧
🟧🟦🟧🟧🟧🟧🟧🟦🟧
🟧🟦🟧⬜️⬜️⬜️🟧🟦🟧
🟧🟦🟧⬜️⬜️⬜️🟧🟦🟧
🟧🟦🟧⬜️⬜️⬜️🟧🟦🟧
🟧🟦🟧🟧🟧🟧🟧🟦🟧
🟧🟦🟦🟦🟦🟦??🟦🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟦🟦🟦🟦🟦🟦🟦🟦🟦
🟦🟧🟧🟧🟧🟧🟧🟧🟦
🟦🟧⬜️⬜️⬜️⬜️⬜️🟧🟦
🟦🟧⬜️⬜️⬜️⬜️⬜️🟧🟦
🟦🟧⬜️⬜️⬜️⬜️⬜️🟧🟦
🟦🟧⬜️⬜️⬜️⬜️⬜️🟧🟦
🟦🟧⬜️⬜️⬜️⬜️⬜️🟧🟦
🟦🟧🟧🟧🟧🟧🟧🟧🟦
🟦🟦🟦🟦🟦🟦🟦🟦🟦',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟧🟧🟧🟧🟧🟧🟧🟧🟧
🟧⬜️⬜️⬜️⬜️⬜️⬜️⬜️🟧
🟧⬜️⬜️⬜️⬜️⬜️⬜️⬜️🟧
🟧⬜️⬜️⬜️⬜️⬜️⬜️⬜️🟧
🟧⬜️⬜️⬜️⬜️⬜️⬜️⬜️🟧
🟧⬜️⬜️⬜️⬜️⬜️⬜️⬜️🟧
🟧⬜️⬜️⬜️⬜️⬜️⬜️⬜️🟧
🟧⬜️⬜️⬜️⬜️⬜️⬜️⬜️🟧
🟧🟧🟧🟧🟧🟧🟧🟧🟧',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥??🟥🟥🟥🟥🟥🟥🟥
🟥⬜⬜⬜⬜⬜⬜⬜⬜️🟥
🟥⬜⬜⬜⬜⬜⬜⬜⬜🟥
🟥⬜⬜⬜⬜⬜⬜⬜⬜🟥
🟥⬜⬜⬜⬜⬜⬜⬜⬜🟥
🟥⬜⬜⬜⬜⬜⬜⬜⬜🟥
🟥⬜⬜⬜⬜⬜⬜⬜⬜🟥
??⬜⬜⬜⬜⬜⬜⬜⬜🟥
🟥⬜⬜⬜⬜⬜⬜⬜⬜🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥⬜⬜⬜⬜⬜⬜🟥🟥
🟥🟥⬜⬜⬜⬜⬜⬜🟥🟥
🟥🟥⬜⬜⬜⬜⬜⬜🟥🟥
🟥🟥⬜⬜⬜⬜⬜⬜🟥🟥
🟥🟥⬜⬜⬜⬜⬜⬜🟥🟥
🟥🟥⬜⬜⬜⬜⬜⬜🟥🟥
??🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥⬜⬜⬜⬜️🟥🟥🟥
🟥🟥🟥⬜⬜⬜⬜🟥🟥🟥
🟥🟥🟥⬜⬜⬜⬜🟥🟥🟥
🟥🟥🟥⬜⬜⬜⬜🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥⬜️⬜️🟥🟥🟥🟥
??🟥??🟥⬜⬜️🟥??🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥??🟥🟥🟥
🟥🟥🟥??🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥??
🟥🟥🟥🟥💙💙🟥🟥🟥🟥
??🟥🟥🟥💙💙🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟦🟦🟥🟥🟥🟥
🟥🟥🟥🟥🟦🟦🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟦🟦🟦🟦🟥🟥🟥
🟥🟥🟥🟦🟦🟦🟦🟥🟥🟥
🟥🟥🟥🟦🟦🟦🟦🟥🟥🟥
🟥🟥🟥🟦🟦🟦🟦🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟨🟨🟨🟨🟨🟨🟥🟥
🟥🟥🟨🟦🟦🟦🟦🟨🟥🟥
🟥🟥🟨🟦🟦🟦🟦🟨🟥🟥
🟥🟥🟨🟦🟦🟦🟦🟨🟥🟥
🟥🟥🟨🟦🟦🟦🟦🟨🟥🟥
🟥🟥🟨🟨🟨🟨🟨🟨🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟨🟨🟨🟨🟨🟨🟨🟨🟥
🟥🟨🟨🟨🟨🟨🟨🟨🟨🟥
🟥🟨🟨🟦🟦🟦🟦🟨🟨🟥
🟥🟨🟨🟦🟦🟦🟦🟨🟨🟥
🟥🟨🟨🟦🟦🟦🟦🟨🟨🟥
🟥🟨🟨🟦🟦🟦🟦🟨🟨🟥
🟥🟨🟨🟨🟨🟨🟨🟨🟨🟥
🟥🟨🟨🟨🟨🟨🟨🟨??🟥
🟥🟥🟥🟥🟥🟥🟥🟥??🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟪🟨🟨🟨🟨🟨🟨🟪🟥
🟥🟨🟪🟨🟨🟨🟨🟪🟨🟥
🟥🟨🟨🟦🟦🟦🟦🟨🟨🟥
🟥🟨🟨🟦🟦🟦🟦🟨🟨🟥
🟥🟨🟨🟦🟦🟦🟦🟨🟨🟥
🟥🟨🟨🟦🟦🟦🟦🟨🟨🟥
🟥🟨🟪🟨🟨🟨🟨🟪🟨🟥
🟥🟪🟨🟨🟨🟨🟨🟨🟪🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟪🟨🟨🟨🟨🟨🟨🟪🟥
🟥🟪🟪🟨🟨🟨🟨🟪🟪🟥
🟥🟪🟨🟦🟦🟦🟦🟨🟪🟥
🟥🟪🟨🟦🟦🟦🟦🟨🟪🟥
🟥🟪🟨🟦🟦🟦🟦🟨🟪🟥
🟥🟪🟨🟦🟦🟦🟦🟨🟪🟥
🟥🟪🟪🟨🟨🟨🟨🟪🟪🟥
🟥🟪🟨🟨🟨🟨🟨🟨🟪🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟪🟩🟩🟩🟩🟩🟩🟪🟥
🟥🟪🟪🟨🟨🟨🟨🟪🟪🟥
🟥🟪🟨🟦🟦🟦🟦🟨🟪🟥
🟥🟪🟨🟦🟦🟦🟦🟨??🟥
🟥🟪🟨🟦🟦🟦🟦🟨🟪🟥
🟥🟪🟨🟦🟦🟦🟦🟨🟪🟥
🟥🟪🟪🟨🟨🟨🟨🟪🟪🟥
🟥🟪🟩🟩🟩🟩🟩🟩🟪🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟪🟩🟩🟩🟩🟩🟩🟪🟥
🟥🟪??⬛️⬛️⬛️⬛️🟪🟪🟥
🟥🟪🟧🟦🟦🟦🟦🟧🟪🟥
🟥🟪🟧🟦🟦🟦🟦🟧🟪🟥
🟥🟪🟧🟦🟦🟦🟦🟧🟪🟥
🟥🟪🟧🟦🟦🟦🟦🟧🟪🟥
🟥🟪🟪⬛️⬛️⬛️⬛️🟪🟪🟥
🟥🟪🟩🟩🟩🟩🟩🟩🟪🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟪🟩🟩🟩🟩🟩🟩🟪🟥
🟥🟪🟪⬛️⬛️⬛️⬛️🟪🟪🟥
🟥🟪🟧🟨🟦🟦🟨🟧🟪🟥
🟥🟪🟧🟦🟨🟨🟦??🟪🟥
🟥🟪🟧🟦🟨🟨🟦🟧🟪🟥
🟥🟪🟧🟨🟦🟦🟨🟧🟪🟥
🟥🟪🟪⬛️⬛️⬛️⬛️🟪🟪🟥
🟥🟪🟩🟩🟩🟩🟩🟩🟪🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟪🟩🟩🟩🟩🟩🟩🟪🟥
🟥🟪🟪⬛️⬛️⬛️⬛️🟪🟪🟥
🟥🟪🟧💛🟦🟦💛🟧🟪🟥
🟥🟪🟧🟦💛💛🟦🟧🟪🟥
🟥🟪🟧🟦💛💛🟦🟧🟪🟥
🟥🟪🟧💛🟦🟦💛🟧🟪🟥
🟥🟪🟪⬛️⬛️⬛️⬛️🟪🟪🟥
🟥🟪🟩🟩🟩🟩🟩🟩🟪🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟪🟩🟩🟩🟩🟩🟩🟪🟥
🟥🟪🟪⬛️⬛️⬛️⬛️🟪🟪🟥
🟥🟪??💛💙💙💛🟧🟪🟥
🟥🟪🟧💙💛💛💙🟧🟪🟥
🟥🟪🟧💙💛💛💙🟧🟪🟥
🟥🟪🟧💛💙💙💛🟧🟪🟥
🟥🟪🟪⬛️⬛️⬛️⬛️🟪🟪🟥
🟥🟪🟩🟩🟩🟩🟩🟩🟪🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥🟪🟩🟩🟩🟩🟩🟩🟪🟥
🟥🟪🟪🖤🖤🖤🖤🟪🟪🟥
🟥🟪🟧💛💙💙💛🟧🟪🟥
🟥🟪🟧💙💛💛💙🟧??🟥
🟥??🟧💙💛💛💙🟧🟪🟥
🟥🟪🟧💛💙💙💛🟧🟪🟥
🟥🟪🟪🖤🖤🖤🖤🟪🟪🟥
🟥🟪🟩🟩🟩🟩🟩🟩🟪🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥💜🟩🟩🟩🟩🟩🟩💜🟥
🟥💜💜🖤🖤🖤🖤💜💜🟥
🟥💜🟧💛💙💙💛🟧💜🟥
??💜🟧💙💛💛💙🟧💜🟥
🟥💜🟧💙💛💛💙🟧💜🟥
🟥💜🟧💛💙💙💛🟧💜🟥
🟥💜💜🖤🖤🖤🖤💜💜🟥
🟥💜🟩🟩🟩🟩🟩🟩💜🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥💜🟩🟩🟩??🟩🟩💜🟥
🟥💜💜🖤🖤🖤🖤💜💜🟥
🟥💜🧡💛💙💙💛🧡💜🟥
🟥💜🧡💙💛💛💙🧡💜🟥
🟥💜🧡💙💛💛💙🧡💜🟥
🟥💜🧡💛💙💙💛🧡💜🟥
🟥💜💜🖤🖤🖤🖤💜💜🟥
🟥💜🟩🟩🟩🟩🟩🟩💜🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥
🟥💜💚💚💚💚💚💚💜🟥
🟥💜💜🖤🖤🖤🖤💜💜🟥
🟥💜🧡💛💙💙💛🧡💜🟥
🟥💜🧡💙💛💛💙🧡💜🟥
🟥💜🧡💙💛💛💙🧡💜🟥
🟥💜🧡💛💙💙💛🧡💜🟥
🟥💜💜🖤🖤🖤🖤💜💜🟥
🟥💜💚💚💚💚💚💚💜🟥
🟥🟥🟥🟥🟥🟥🟥🟥🟥🟥',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️
❤️💜💚💚💚💚💚💚💜❤️
❤️💜💜🖤🖤🖤🖤💜💜❤️
❤️💜🧡💛💙💙💛🧡💜❤️
❤️💜🧡💙💛💛💙🧡💜❤️
❤️💜🧡💙💛💛??🧡💜❤️
❤️💜🧡💛💙💙💛🧡💜❤️
❤️💜💜🖤🖤🖤🖤💜💜❤️
❤️💜💚💚💚💚💚💚💜❤️
❤️❤️❤️❤️❤️❤️❤️❤️❤️❤️',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️◻️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '⬜️⬜️⬜️⬜️⬜️⬜️⬜️◻️◽️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️◻️◻️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '⬜️⬜️⬜️⬜️⬜️⬜️◻️◽️▫️
⬜️⬜️⬜️⬜️⬜️⬜️◻️◽️◽️
⬜️⬜️⬜️⬜️⬜️⬜️◻️◻️◻️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '⬜️⬜️⬜️⬜️⬜️◻️◽️▫️▫️
⬜️⬜️⬜️⬜️⬜️◻️◽️▫️▫️
⬜️⬜️⬜️⬜️⬜️◻️◽️◽️◽️
⬜️⬜️⬜️⬜️⬜️◻️◻️◻️◻️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '⬜️⬜️⬜️⬜️◻️◽️▫️▫️▫️
⬜️⬜️⬜️⬜️◻️◽️▫️▫️▫️
⬜️⬜️⬜️⬜️◻️◽️▫️▫️▫️
⬜️⬜️⬜️⬜️◻️◽️◽️◽️◽️
⬜️⬜️⬜️⬜️◻️◻️◻️◻️◻️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '⬜️⬜️⬜️◻️◽️▫️▫️▫️▫️
⬜️⬜️⬜️◻️◽️▫️▫️▫️▫️
⬜️⬜️⬜️◻️◽️▫️▫️▫️▫️
⬜️⬜️⬜️◻️◽️▫️▫️▫️▫️
⬜️⬜️⬜️◻️◽️◽️◽️◽️◽️
⬜️⬜️⬜️◻️◻️◻️◻️◻️◻️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '⬜️⬜️◻️◽️▫️▫️▫️▫️▫️
⬜️⬜️◻️◽️▫️▫️▫️▫️▫️
⬜️⬜️◻️◽️▫️▫️▫️▫️▫️
⬜️⬜️◻️◽️▫️▫️▫️▫️▫️
⬜️⬜️◻️◽️▫️▫️▫️▫️▫️
⬜️⬜️◻️◽️◽️◽️◽️◽️◽️
⬜️⬜️◻️◻️◻️◻️◻️◻️◻️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '⬜️◻️◽️▫️▫️▫️▫️▫️▫️
⬜️◻️◽️▫️▫️▫️▫️▫️▫️
⬜️◻️◽️▫️▫️▫️▫️▫️▫️
⬜️◻️◽️▫️▫️▫️▫️▫️▫️
⬜️◻️◽️▫️▫️▫️▫️▫️▫️
⬜️◻️◽️▫️▫️▫️▫️▫️▫️
⬜️◻️◽️◽️◽️◽️◽️◽️◽️
⬜️◻️◻️◻️◻️◻️◻️◻️◽️
⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '◻️◽️▫️▫️▫️▫️▫️▫️▫️
◻️◽️▫️▫️▫️▫️▫️▫️▫️
◻️◽️▫️▫️▫️▫️▫️▫️▫️
◻️◽️▫️▫️▫️▫️▫️▫️▫️
◻️◽️▫️▫️▫️▫️▫️▫️▫️
◻️◽️▫️▫️▫️▫️▫️▫️▫️
◻️◽️▫️▫️▫️▫️▫️▫️▫️
◻️◽️◽️◽️◽️◽️◽️◽️◽️
◻️◻️◻️◻️◻️◻️◻️◻️◻️',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '◽️▫️▫️▫️▫️▫️▫️▫️▫️
◽️▫️▫️▫️▫️▫️▫️▫️▫️
◽️▫️▫️▫️▫️▫️▫️▫️▫️
◽️▫️▫️▫️▫️▫️▫️▫️▫️
◽️▫️▫️▫️▫️▫️▫️▫️▫️
◽️▫️▫️▫️▫️▫️▫️▫️▫️
◽️▫️▫️▫️▫️▫️▫️▫️▫️
◽️▫️▫️▫️▫️▫️▫️▫️▫️
◽️◽️◽️◽️◽️◽️◽️◽️◽',
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => '▫️▫️▫️▫️▫️▫️▫️▫️▫️
▫️▫️▫️▫️▫️▫️▫️▫️▫️
▫️▫️▫️▫️▫️▫️▫️▫️▫️
▫️▫️▫️▫️▫️▫️▫️▫️▫️
▫️▫️▫️▫️▫️▫️▫️▫️▫️
▫️▫️▫️▫️▫️▫️▫️▫️▫️
▫️▫️▫️▫️▫️▫️▫️▫️▫️
▫️▫️▫️▫️▫️▫️▫️▫️▫️
▫️▫️▫️▫️▫️▫️▫️▫️▫️',
					]);
				}
				if ($text == "گلب" or $text == "qlb2") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💚💛🧡❤️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💙💚💜🖤",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "❤️🤍🧡💚",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖤💜💙💚",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🤍🤎❤️💙",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🖤💜💚💙",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💝💘💗💘",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "❤️🤍🤎🧡",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💕💞💓🤍",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💜💙❤️🤍",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💙💜💙💚",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🧡💚🧡💙",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💝💜💙❤️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💞🖤💙💚",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "💛🧡❤️💚",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "😍Im crazy about you😍",
					]);
				}
				if ($text == "مربع2" or $text == "mor") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🟪🟩🟨⬛️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "??🟨🟩🟦",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🟪🟦🟥🟩",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "⬜️⬛️⬜️🟪",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🟨🟦🟪🟩",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🟥⬛️🟪🟦",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🟧🟩🟫🟨",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🔳🔲◻️🟥",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "▪️▫️◽️◼️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "◻️◼️◽️▪️",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🟪🟦🟨🟪",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🟥⬛️🟪🟩",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🟧🟨🟥🟦",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🟩🟦🟩🟪",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🍁entire🍁",
					]);
				}
				if ($text == "قلب2" or $text == "ghalb") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤍🧡💛
💚	 🤎
❤️💜🖤
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
💙🧡💛
💚	 🤎
❤️💜🖤
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤍💙??
💚	 🤎
❤️💜🖤
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤍🧡💙
💚	 🤎
❤️💜🖤
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤍🧡💛
💚	 💙
❤️💜🖤
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤍🧡💛
💚	 🤎
❤️💜💙
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤍🧡💛
💚	 🤎
❤️💙🖤
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤍🧡💛
💚	 🤎
💙💜🖤
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤍🧡💛
💙	 🤎
❤️💜🖤
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
💙🧡💛
💚	 🤎
❤️💜🖤
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤍💙💛
💚	 🤎
❤️💜🖤
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤍🧡💙
💚	 🤎
❤️💜🖤
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤍🧡💛
💚	 💙
❤️💜🖤
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤍🧡💛
💚	 🤎
❤️💜💙
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤍🧡💛
💚	 🤎
❤️💙🖤
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤍🧡💛
💚	 🤎
💙💜🖤
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤍🧡💛
💙	 🤎
❤️💜🖤
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
💙🧡💛
💚	 🤎
❤️💜🖤
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤍💙💛
💚	 🤎
❤️💜🖤
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤍🧡💙
💚	 🤎
❤️💜🖤
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤍🧡💛
💚	 💙
❤️💜🖤
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤍🧡💛
💚	 🤎
❤️💜💙
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤍🧡💛
💚	 🤎
❤️💙🖤
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤍🧡💛
💚	 🤎
💙💜🖤
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤍🧡💛
💙	 🤎
❤️💜🖤
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
💙🧡💛
💚	 🤎
❤️💜🖤
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤍💙💛
💚	 🤎
❤️💜🖤
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤍🧡💙
💚	 🤎
❤️💜🖤
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤍🧡💛
💚	 💙
❤️💜🖤
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤍🧡💛
💚	 🤎
❤️💜💙
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤍🧡💛
💚	 🤎
❤️💙🖤
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤍🧡💛
💚	 🤎
💙💜🖤
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
❤️💙🧡
🤎 ♡🤍
🖤💜💚
",
					]);
				}
				if ($text == "رقص2" or $text == "raqs") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
-~(._. )--

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
~-(._. )--

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
--( ._.)~-

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
--( ._.)-~

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
-~( ._.)--

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
--(._. )~-
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
-~(._. )--

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
~-(._. )--

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
--( ._.)~-

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
--( ._.)-~

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
-~(._. )--

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
~-(._. )--

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
--( ._.)~-

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
--( ._.)-~

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
-~(._. )--

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
~-(._. )--

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
--( ._.)~-

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
-~(._. )--

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
~-(._. )--

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
--( ._.)~-

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
--( ._.)-~

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
-~( ._.)--

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
--(._. )~-
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
-~(._. )--

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
~-(._. )--

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
--( ._.)~-

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
--( ._.)-~

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
-~(._. )--

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
~-(._. )--

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
--( ._.)~-

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
--( ._.)-~

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
-~(._. )--

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
~-(._. )--

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
--( ._.)~-

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
--( ._.)-~
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
-~(._. )--

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
~-(._. )--

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
--( ._.)~-

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
--( ._.)-~

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
-~( ._.)--

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
--(._. )~-
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
-~(._. )--

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
~-(._. )--

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
--( ._.)~-

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
--( ._.)-~

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
-~(._. )--

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
~-(._. )--

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
--( ._.)~-

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
--( ._.)-~

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
-~(._. )--

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
~-(._. )--

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
--( ._.)~-

",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
--( ._.)-~
تامام
",
					]);
				}
				if ($text == "کیر2" or $text == "kir2") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "


.								🟦🟦🟦🟦🟦
		


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟦🟦🟦🟦🟦
		 🟦
		 🟦
		 🟦
		 🟦



",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟦🟦🟦🟦🟦
		 🟦
		 🟦
		 🟦
🟦	 🟦
🟦🟦🟦??🟦🟦


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟦🟦🟦🟦🟦
		 🟦
		 🟦
		 🟦
🟦	 🟦
🟦🟦🟦🟦🟦🟦
🟦
🟦	   


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "


.								🟦🟦🟦🟦🟦
		 🟦
		 🟦
		 🟦
🟦	 🟦
🟦🟦🟦🟦🟦🟦
🟦🟦
🟦🟦		


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟦🟦🟦🟦🟦
		 🟦
		 🟦
		 🟦
🟦	 🟦
🟦🟦🟦🟦🟦🟦
🟦🟦
🟦🟦		🟦🟦


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟦🟦🟦🟦🟥
		 🟦
		 🟦
		 🟦
🟦	 🟦
🟦🟦🟦🟦🟦🟦
🟦🟦
🟦🟦		🟦🟦


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟦🟦🟦🟥🟥
		 🟦
		 🟦
		 🟦
🟦	 🟦
🟦🟦🟦🟦🟦🟦
🟦🟦
🟦🟦		🟦🟦


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟦🟦🟥🟥🟥
		 🟦
		 🟦
		 🟦
🟦	 🟦
🟦🟦🟦🟦🟦🟦
🟦🟦
🟦🟦		🟦🟦


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟦🟥🟥🟥🟥
		 🟦
		 🟦
		 🟦
🟦	 🟦
🟦🟦🟦🟦🟦🟦
🟦🟦
🟦🟦		🟦🟦


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟥🟥🟥🟥🟥
		 🟦
		 🟦
		 🟦
🟦	 🟦
🟦🟦🟦🟦🟦🟦
🟦🟦
🟦🟦		🟦🟦


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟥🟥🟥🟥🟥
		 🟥
		 🟦
		 🟦
🟦	 🟦
🟦🟦🟦🟦🟦🟦
🟦🟦
🟦🟦		🟦🟦


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟥🟥🟥🟥🟥
		 🟥
		 🟥
		 🟦
🟦	 🟦
🟦🟦🟦🟦🟦🟦
🟦🟦
🟦🟦		🟦🟦


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟥🟥🟥🟥🟥
		 🟥
		 🟥
		 🟥
🟦	 🟦
🟦🟦🟦🟦🟦🟦
🟦🟦
🟦🟦		🟦🟦


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟥🟥🟥🟥??
		 🟥
		 🟥
		 🟥
🟦	 🟥
🟦🟦🟦🟦🟦🟦
🟦🟦
🟦🟦		🟦🟦


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟥🟥🟥🟥🟥
		 🟥
		 🟥
		 🟥
🟦	 🟥
🟦🟦🟦🟦🟦🟥
🟦🟦
🟦🟦		🟦🟦


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟥🟥🟥🟥🟥
		 🟥
		 🟥
		 🟥
🟦	 🟥
🟦🟦🟦🟦🟥🟥
🟦🟦
🟦🟦		🟦🟦


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟥🟥🟥🟥🟥
		 🟥
		 🟥
		 🟥
🟦	 🟥
🟦🟦🟦🟥🟥🟥
🟦🟦
🟦🟦		🟦🟦


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟥🟥🟥🟥🟥
		 🟥
		 🟥
		 🟥
🟥	 🟥
🟦🟦🟦🟥🟥🟥
🟦🟦
🟦🟦		🟦🟦


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟥🟥🟥🟥🟥
		 🟥
		 🟥
		 ??
🟥	 🟥
🟦🟦🟥🟥🟥🟥
🟦🟦
🟦🟦		🟦🟦


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟥🟥🟥🟥🟥
		 🟥
		 🟥
		 🟥
🟥	 🟥
🟦🟥🟥🟥🟥🟥
🟦🟦
🟦🟦		🟦🟦


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟥🟥🟥🟥🟥
		 🟥
		 🟥
		 🟥
🟥	 🟥
🟥🟥🟥🟥🟥🟥
🟦🟦
🟦🟦		🟦🟦


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟥🟥🟥🟥🟥
		 🟥
		 🟥
		 🟥
🟥	 🟥
🟥🟥🟥🟥🟥🟥
🟦🟥
🟦🟦		🟦🟦


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟥🟥🟥🟥🟥
		 🟥
		 🟥
		 ??
🟥	 🟥
🟥🟥🟥🟥🟥🟥
🟥🟥
🟦🟦		🟦🟦


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟥🟥🟥🟥🟥
		 🟥
		 🟥
		 🟥
🟥	 🟥
🟥🟥🟥🟥🟥🟥
🟥🟥
🟦🟥		🟦🟦


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟥🟥🟥🟥🟥
		 🟥
		 ??
		 🟥
🟥	 🟥
🟥🟥🟥🟥🟥🟥
🟥🟥
🟥🟥		🟦🟦


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟥🟥🟥🟥🟥
		 🟥
		 🟥
		 🟥
🟥	 🟥
🟥🟥🟥🟥🟥🟥
🟥🟥
🟥🟥		🟥🟦


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟥🟥🟥🟥🟥
		 🟥
		 🟥
		 🟥
🟥	 🟥
🟥🟥🟥🟥🟥🟥
🟥🟥
🟥🟥		🟥🟥


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟧🟨🟩🟦🟪
		 🟪
		 🟦
		 🟩
🟦	 🟨
🟫⬜️🟪🟩🟨🟧
🟥🟥
🟥🟥		🟥🟥


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟧🟨🟩🟦??
		 🟪
		 🟦
		 🟩
🟦	 🟨
🟫⬜️🟪🟩🟨🟧
🟪⬜️
🟩🟦		🟨🟧


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟧🟨🟩🟦⬛️
		 🟪
		 🟦
		 🟩
🟦	 🟨
🟫⬜️🟪🟩🟨🟧
🟪⬜️
🟩🟦		🟨🟧


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟧🟨🟩⬛️🟪
		 🟪
		 🟦
		 🟩
🟦	 🟨
🟫⬜️🟪🟩🟨🟧
🟪⬜️
🟩🟦		🟨🟧


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟧🟨⬛️🟦🟪
		 🟪
		 🟦
		 🟩
🟦	 🟨
🟫⬜️🟪🟩🟨🟧
🟪⬜️
🟩🟦		🟨🟧


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟧⬛️🟩🟦🟪
		 🟪
		 🟦
		 🟩
🟦	 🟨
🟫⬜️🟪🟩🟨🟧
🟪⬜️
🟩🟦		🟨🟧


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								⬛️🟨🟩🟦🟪
		 🟪
		 🟦
		 🟩
🟦	 🟨
🟫⬜️🟪🟩🟨🟧
🟪⬜️
🟩🟦		🟨🟧


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟧🟨🟩🟦🟪
		 ⬛️
		 🟦
		 🟩
🟦	 ??
🟫⬜️🟪🟩🟨🟧
🟪⬜️
🟩🟦		🟨🟧


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟧🟨🟩🟦🟪
		 🟪
		 ⬛️
		 🟩
🟦	 🟨
🟫⬜️🟪🟩🟨🟧
🟪⬜️
🟩🟦		🟨🟧


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟧🟨🟩🟦🟪
		 🟪
		 ??
		 ⬛️
🟦	 🟨
🟫⬜️🟪🟩🟨🟧
🟪⬜️
🟩🟦		🟨🟧


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟧🟨🟩🟦🟪
		 🟪
		 🟦
		 🟩
🟦	 ⬛️
🟫⬜️🟪🟩🟨🟧
🟪⬜️
🟩🟦		🟨🟧


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟧🟨🟩🟦🟪
		 🟪
		 🟦
		 🟩
🟦	 🟨
🟫⬜️🟪🟩🟨⬛️
🟪⬜️
🟩🟦		🟨🟧


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟧🟨🟩🟦🟪
		 🟪
		 🟦
		 🟩
🟦	 🟨
🟫⬜️🟪🟩⬛️🟧
🟪⬜️
🟩🟦		🟨🟧


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟧🟨🟩🟦🟪
		 🟪
		 🟦
		 🟩
🟦	 🟨
🟫⬜️🟪⬛️🟨🟧
🟪⬜️
🟩🟦		🟨🟧


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟧🟨🟩🟦🟪
		 🟪
		 🟦
		 🟩
⬛️	 🟨
🟫⬜️🟪🟩🟨🟧
🟪⬜️
🟩🟦		🟨🟧


",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟧🟨🟩🟦🟪
		 🟪
		 🟦
		 🟩
🟦	 🟨
🟫⬜️⬛️🟩🟨🟧
🟪⬜️
🟩🟦		🟨🟧


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟧🟨🟩🟦🟪
		 🟪
		 🟦
		 🟩
🟦	 🟨
🟫⬛️🟪🟩🟨🟧
🟪⬜️
🟩🟦		🟨🟧


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟧🟨🟩🟦🟪
		 🟪
		 🟦
		 🟩
🟦	 🟨
⬛️⬜️🟪🟩🟨🟧
🟪⬜️
🟩🟦		🟨🟧


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟧🟨🟩🟦🟪
		 🟪
		 🟦
		 🟩
🟦	 🟨
🟫⬜️🟪🟩🟨🟧
🟪⬛️
🟩🟦		🟨🟧


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟧🟨🟩🟦🟪
		 🟪
		 🟦
		 🟩
🟦	 🟨
🟫⬜️🟪🟩🟨🟧
⬛️⬜️
🟩🟦		🟨🟧


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟧🟨🟩🟦🟪
		 🟪
		 🟦
		 🟩
🟦	 🟨
🟫⬜️🟪🟩🟨🟧
🟪⬜️
🟩⬛️		🟨🟧


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟧🟨🟩🟦🟪
		 🟪
		 🟦
		 🟩
🟦	 🟨
🟫⬜️🟪🟩🟨🟧
🟪⬜️
⬛️🟦		🟨🟧


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟧🟨🟩🟦🟪
		 🟪
		 🟦
		 🟩
🟦	 🟨
🟫⬜️🟪🟩🟨🟧
🟪⬜️
🟩🟦		⬛️🟧


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟧🟨🟩🟦🟪
		 🟪
		 🟦
		 🟩
🟦	 🟨
🟫⬜️🟪🟩🟨🟧
🟪⬜️
🟩🟦		🟨⬛️


",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "

.								🟧🟨🟩🟦🟪
		 🟪
		 🟦
		 🟩
🟦	 🟨
🟫⬜️🟪🟩🟨🟧
🟪⬜️
🟩🟦		🟨🟧

یاح یاح یاح
",
					]);
				}
				if ($text == "بکشش" or $text == "bokoshesh") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
😐					 •🔫
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
😐					• 🔫
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
😐				  •   🔫
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
😐				•	 🔫
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
😐			  •	   🔫
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
😐			•		 🔫
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
😐		   •		  🔫
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
😐		 •			🔫
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
😐	   •			  🔫
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
😐	 •				🔫
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
😐   •				  🔫
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
😐 •					🔫
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
😐•					 🔫
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
😵					   🔫😏
",
					]);
				}
				if ($text == "bk2" or $text == "بکیرم2") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤤🤤🤤
🤤		 🤤
🤤		   🤤
🤤		🤤
🤤🤤🤤
🤤		 🤤
🤤		   🤤
🤤		   🤤
🤤		🤤
🤤🤤🤤
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
😂		 😂
😂	   😂
😂	 😂
😂   😂
😂😂
😂   😂
😂	  😂
😂		😂
😂		  😂
😂			😂",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
👽👽👽		  👽		 👽
😍		 ??	  😍	   😍
😎		   😎	😎	 😎
🤬		🤬	   🤬   🤬
😄😄😄		  🤓 🤓
🤨		 😊	  😋   😋
🤯		   🤯	🤯	 🤯
🤘		   🤘	😘		😘
🤫	   🤫		🙊		  🙊
🤡🤡🤡		  😗			 🙊",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
💋💋💋		  💋		 💋
😏		 😏	  😏	   😏
😏		   😏	😏	 😏
😄		😄	   😄   😄
😄😄😄		  😄😄
🤘		 🤘	  ??   🤘
🤘		   🤘	🤘	  🤘
🙊		   🙊	🙊		🙊
🙊	   🙊		🙊		  🙊
💋💋💋		  💋			💋",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
😏😏😏		  😏		 😏
😏		 😏	  😏	   😏
😄		   😄	😄	 😄
😄		😄	   😄   😄
🤘🤘🤘		  🤘🤘
🤘		 🤘	  🤘   🤘
🙊		   🙊	🙊	  🙊
🙊		   🙊	🙊		🙊
💋	   💋		💋		  💋
💋💋??		  💋			💋",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
😏😏😏		  😏		 😏
😄		 😄	  😄	   😄
😄		   😄	😄	 😄
🤘		🤘	   🤘   🤘
🤘🤘🤘		  🤘🤘
🙊		 🙊	  🙊   🙊
??		   🙊	🙊	  🙊
💋		   💋	💋		💋
💋	   💋		💋		  💋
😏😏😏		  😏			😏",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
😄😄😄		  😄		 😄
😄		 😄	  😄	   😄
🤘		   🤘	🤘	 🤘
🤘		🤘	   🤘   🤘
🙊🙊🙊		  🙊🙊
🙊		 🙊	  🙊   🙊
💋		   💋	💋	  💋
💋		   💋	💋		💋
😏	   😏		😏		  😏
😏😏😏		  😏			😏
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
😄😄😄		  😄		 😄
🤘		 🤘	  🤘	   🤘
🤘		   🤘	🤘	 🤘
🙊		🙊	   🙊   🙊
🙊🙊🙊		  🙊🙊
💋		 💋	  💋   💋
💋		   💋	💋	  💋
😏		   😏	😏		😏
😏	   😏		😏		  😏
😄😄😄		  😄			😄
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤘🤘🤘		  🤘		 🤘
🤘		 🤘	  🤘	   🤘
🙊		   🙊	🙊	 🙊
🙊		🙊	   🙊   🙊
💋💋💋		  💋💋
💋		 💋	  💋   💋
😏		   😏	😏	  😏
😏		   😏	😏		😏
😄	   😄		😄		  😄
😄😄😄		  😄			😄
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤘🤘🤘		  🤘		 🤘
🙊		 🙊	  🙊	   🙊
🙊		   🙊	🙊	 🙊
💋		💋	   💋   💋
💋💋💋		  💋💋
😏		 😏	  😏   😏
😏		   😏	😏	  😏
😄		   😄	😄		😄
😄	   😄		😄		  😄
🤘🤘🤘		  🤘			🤘
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🙊🙊🙊		  🙊		 🙊
🙊		 🙊	  🙊	   🙊
💋		   💋	💋	 💋
💋		💋	   💋   💋
😏😏😏		  😏😏
😏		 ??	  😏   😏
😄		   😄	😄	  😄
😄		   😄	😄		😄
🤘	   🤘		🤘		  🤘
🤘🤘🤘		  🤘			🤘
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🙊🙊🙊		  🙊		 🙊
💋		 💋	  💋	   💋
💋		   💋	💋	 💋
😏		😏	   😏   😏
😏😏😏		  😏😏
😄		 😄	  😄   😄
😄		   😄	😄	  😄
🤘		   🤘	🤘		🤘
🤘	   🤘		🤘		  🤘
🙊🙊🙊		  🙊			🙊
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
💋??💋		  💋		 💋
💋		 💋	  💋	   💋
😏		   😏	😏	 😏
😏		😏	   😏   😏
😄😄😄		  😄😄
😄		 😄	  😄   😄
🤘		   🤘	🤘	  🤘
🤘		   🤘	🤘		🤘
🙊	   🙊		🙊		  🙊
🙊🙊🙊		  🙊			🙊
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
💋💋💋		  💋		 💋
😏		 😏	  😏	   😏
😏		   😏	😏	 😏
😄		😄	   😄   😄
😄😄😄		  😄😄
🤘		 🤘	  🤘   🤘
🤘		   🤘	🤘	  🤘
🙊		   🙊	🙊		🙊
🙊	   🙊		🙊		  🙊
💋💋💋		  💋			💋
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
😏😏😏		  😏		 😏
😏		 😏	  😏	   😏
😄		   😄	😄	 😄
😄		😄	   😄   😄
🤘🤘🤘		  🤘🤘
🤘		 🤘	  🤘   🤘
🙊		   🙊	🙊	  🙊
🙊		   🙊	🙊		🙊
💋	   💋		💋		  💋
💋💋💋		  💋			💋
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
😏😏😏		  😏		 😏
😄		 😄	  😄	   😄
😄		   😄	😄	 😄
🤘		🤘	   🤘   🤘
🤘🤘🤘		  🤘🤘
🙊		 🙊	  🙊   🙊
🙊		   🙊	🙊	  🙊
💋		   💋	💋		💋
💋	   💋		💋		  💋
😏😏😏		  😏			😏
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
😄😄😄		  😄		 😄
😄		 😄	  😄	   😄
🤘		   🤘	🤘	 🤘
🤘		🤘	   🤘   🤘
🙊🙊🙊		  🙊🙊
🙊		 🙊	  🙊   🙊
💋		   💋	💋	  💋
💋		   💋	💋		💋
😏	   😏		😏		  😏
😏😏😏		  😏			😏
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
😄😄😄		  😄		 😄
🤘		 🤘	  🤘	   🤘
🤘		   🤘	🤘	 🤘
🙊		🙊	   🙊   🙊
🙊🙊??		  🙊🙊
💋		 💋	  💋   💋
💋		   💋	💋	  💋
😏		   😏	😏		😏
😏	   😏		😏		  😏
😄😄😄		  😄			😄
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤘🤘🤘		  🤘		 🤘
🤘		 🤘	  🤘	   🤘
🙊		   🙊	🙊	 🙊
🙊		🙊	   🙊   🙊
💋💋💋		  💋💋
💋		 💋	  💋   💋
😏		   😏	😏	  😏
😏		   😏	😏		😏
😄	   😄		😄		  😄
😄😄😄		  😄			😄
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤘🤘🤘		  🤘		 🤘
🙊		 🙊	  🙊	   🙊
🙊		   🙊	🙊	 🙊
💋		💋	   💋   💋
💋💋💋		  💋💋
😏		 😏	  😏   😏
😏		   😏	😏	  😏
😄		   ??	😄		😄
😄	   😄		😄		  😄
🤘🤘🤘		  🤘			🤘
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🙊🙊🙊		  🙊		 🙊
🙊		 🙊	  🙊	   🙊
💋		   💋	💋	 💋
💋		💋	   💋   💋
😏😏😏		  😏😏
😏		 😏	  😏   😏
😄		   😄	😄	  😄
😄		   😄	😄		😄
🤘	   🤘		🤘		  🤘
🤘🤘🤘		  🤘			🤘
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🙊🙊🙊		  🙊		 🙊
💋		 💋	  💋	   💋
💋		   💋	💋	 💋
😏		😏	   😏   😏
😏😏😏		  😏😏
😄		 😄	  😄   😄
😄		   😄	😄	  😄
🤘		   🤘	🤘		🤘
🤘	   🤘		🤘		  ??
🙊🙊🙊		  🙊			🙊
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
💋💋💋		  💋		 💋
💋		 💋	  💋	   ??
😏		   😏	😏	 😏
😏		😏	   😏   😏
😄??😄		  😄😄
😄		 😄	  😄   😄
🤘		   🤘	🤘	  🤘
🤘		   🤘	🤘		🤘
🙊	   🙊		🙊		  🙊
🙊🙊🙊		  🙊			🙊
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
💋??💋		  💋		 💋
😏		 😏	  😏	   😏
😏		   😏	😏	 😏
😄		😄	   😄   😄
😄😄😄		  😄😄
🤘		 🤘	  🤘   🤘
🤘		   ??	🤘	  🤘
🙊		   🙊	🙊		🙊
🙊	   🙊		🙊		  🙊
💋💋💋		  💋			💋
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
😏😏😏		  😏		 😏
😏		 😏	  😏	   😏
😄		   😄	😄	 😄
😄		😄	   😄   😄
🤘🤘🤘		  🤘🤘
🤘		 🤘	  🤘   🤘
🙊		   🙊	🙊	  🙊
🙊		   🙊	🙊		🙊
💋	   💋		💋		  💋
💋💋💋		  💋			💋
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
😏😏😏		  😏		 😏
😄		 😄	  😄	   😄
😄		   😄	??	 😄
🤘		🤘	   🤘   🤘
🤘🤘🤘		  🤘🤘
🙊		 🙊	  🙊   🙊
🙊		   ??	🙊	  🙊
💋		   💋	💋		💋
??	   💋		💋		  💋
😏😏😏		  😏			😏
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
😄😄😄		  😄		 ??
😄		 😄	  😄	   😄
🤘		   🤘	🤘	 🤘
🤘		🤘	   🤘   🤘
🙊🙊🙊		  🙊🙊
🙊		 🙊	  🙊   🙊
💋		   💋	💋	  💋
💋		   💋	💋		💋
😏	   😏		😏		  😏
😏😏😏		  😏			😏
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
😄😄😄		  😄		 😄
🤘		 🤘	  🤘	   🤘
🤘		   🤘	🤘	 🤘
🙊		🙊	   🙊   🙊
🙊🙊🙊		  🙊🙊
💋		 💋	  💋   💋
💋		   💋	💋	  💋
😏		   😏	😏		😏
😏	   😏		😏		  😏
😄😄😄		  😄			😄
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤘🤘🤘		  🤘		 🤘
🤘		 🤘	  🤘	   🤘
🙊		   🙊	🙊	 🙊
🙊		🙊	   🙊   🙊
💋💋💋		  💋💋
💋		 💋	  💋   💋
😏		   😏	😏	  😏
😏		   😏	😏		😏
😄	   😄		😄		  😄
😄😄😄		  😄			😄
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤘🤘🤘		  🤘		 🤘
🙊		 🙊	  🙊	   🙊
🙊		   🙊	🙊	 🙊
💋		💋	   💋   💋
💋💋💋		  💋💋
😏		 😏	  😏   😏
😏		   😏	😏	  😏
😄		   😄	😄		😄
😄	   😄		😄		  😄
🤘🤘🤘		  🤘			🤘
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🙊🙊🙊		  🙊		 🙊
🙊		 🙊	  🙊	   🙊
💋		   💋	💋	 💋
💋		💋	   💋   💋
😏😏😏		  😏😏
😏		 😏	  😏   😏
😄		   😄	😄	  😄
😄		   😄	😄		😄
🤘	   🤘		🤘		  🤘
🤘🤘🤘		  🤘			🤘
",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "
🤬🤬🤬		  🤬		 🤬
😡		 😡	  😡	   😡
🤬		   🤬	🤬	 🤬
😡		😡	   😡   😡
🤬🤬🤬		  🤬🤬
😡		 😡	  😡   😡
🤬		   🤬	🤬	  🤬
😡		   😡	😡		😡
🤬	   🤬		🤬		  🤬
😡😡😡		  😡			😡

بانک کشاورزی 😐",
					]);
				}
				if ($text == "زنبور2" or $text == "viz2") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏥__________🏃‍♂️______________🐝",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏥______🏃‍♂️_______🐝",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏥______🏃‍♂️_____🐝",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏥___🏃‍♂️___🐝",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏥_🏃‍♂️_🐝",
					]);
					yield $this->sleep(0.4);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "در رفت عه☹️🐝",
					]);
				}

				if ($text == "زنبور" or $text == "vizviz") {
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏃‍♂??_______🏃😱😳🚶‍♂________🐝",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏃‍♂😥_______________🐝",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏃‍♂😥______________🐝",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏃‍♂😥_____________🐝",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏃‍♂😥____________🐝",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏃‍♂😥___________🐝",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏃‍♂😥__________🐝",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏃‍♂😥_________🐝",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏃‍♂😥________🐝",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏃‍♂😥_______🐝",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏃‍♂😥______🐝",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏃‍♂😥____🐝",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏃‍♂😥___🐝",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏃‍♂😥__🐝",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "🏃‍♂😥_🐝",
					]);
					yield $this->sleep(0.4);

					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "👨‍🦽😭🥺",
					]);
				}
				//-------------------- End Of Fun ---------------------
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
• Support : [SisTan_KinG](https://t.me/SisTan_KinG)
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
				// اطلاعات آب و هوا
				if (
					preg_match("/^[\/\#\!]?(weather|اب و هوا) (.*)$/i", $text)
				) {
					preg_match(
						"/^[\/\#\!]?(weather|اب و هوا) (.*)$/i",
						$text,
						$m
					);
					if (
						$type3 == "supergroup" ||
						$type3 == "chat" ||
						$type3 == "user"
					) {
						$mu = $m[2];
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» ʀᴇᴄᴇɪᴠɪɴɢ ( `$m[2]` ) ᴄɪᴛʏ ᴡᴇᴀᴛʜᴇʀ ɪɴғᴏʀᴍᴀᴛɪᴏɴ . . . !",
							"parse_mode" => "markdown",
						]);
						$res = json_decode(
							file_get_contents(
								"https://api.codebazan.ir/weather/?city=$mu"
							),
							true
						);
						if ($res["result"]["استان"] != null) {
							$os = $res["result"]["استان"];
							$ci = $res["result"]["شهر"];
							$da = $res["result"]["دما"];
							$so = $res["result"]["سرعت باد"];
							$ha = $res["result"]["وضعیت هوا"];
							$up = $res["result"]["به روز رسانی"];
							yield $this->messages->sendMessage([
								"peer" => $peer,
								"message" => "
🛤 استان » **$os**
🏘 شهر » **$ci**
🌞 دما » **$da**
💨 سرعت باد » **$so**
☀️ وضعیت هوا » **$ha**
♻️ بروز رسانی در » **$up**
",
								"parse_mode" => "markdown",
								"reply_to_msg_id" => $msg_id,
							]);
						} else {
							yield $this->messages->sendMessage([
								"peer" => $peer,
								"message" => "» ᴇɴᴛᴇʀᴇᴅ ᴄɪᴛʏ ɪs ɪɴᴠᴀʟɪᴅ !",
								"parse_mode" => "markdown",
								"reply_to_msg_id" => $msg_id,
							]);
						}
					}
				}

				/*
// دانلود عکس زمان دار 
if( preg_match( '/^[\/\#\!\.]?(dl|download|wait|دانلود|دانلود بشه|صبر|صبرکن|صبر کن|صب کن|صبکن|صب کن ببینم|صبر کن ببینم)$/si', $text ) ){
if (isset($update['message']['reply_to_msg_id'])) {
$rp = $update['message']['reply_to_msg_id'];
if($type3 == "user"){
$messeg = yield $this->messages->getMessages(['id' => [$rp],]);
}
if (isset($messeg['messages'][0]['media']['photo'])) {
$media = $messeg['messages'][0]['media'];
$captcha = rand(111111,999999);
$ca = substr($captcha, 0, 7);
yield $this->downloadToFile($media, "files/$ca.png");
# yield $this->messages->editMessage(['peer' => $peer, 'id' => $msg_id, 'message' => "» درحال ذخیره عکس زمان دار . . . !", 'parse_mode'=>"MarkDown"]);
yield $this->messages->sendMedia([
'peer' => $admin, 
'media' =>['_' => 'inputMediaUploadedDocument', 
'file' => "files/$ca.png", 
'attributes' => [['_' => 'documentAttributeFilename', 
'file_name' => "SK_$ca.png"]]]]);
} 
}
}
*/
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
**@SisTan_KinG ～ @SisSeLf**";
					} else {
						$t = "Latest Version Is **$LatestVersion**, Your Bot Current Version Is **$CurrentVersion**
**Your Bot is Up To Date ✅
@SisTan_KinG ～ @SisSeLf**";
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
**@SisTan_KinG ～ @SisSeLf**";
						touch("UpDate");
					} else {
						$t = "**Your Bot is Up To Date ✅
@SisTan_KinG ～ @SisSeLf**";
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
				//================ Flood ================
				if (preg_match("/^[\/\#\!]?(flood) ([0-9]+) (.*)$/i", $text)) {
					preg_match(
						"/^[\/\#\!]?(flood) ([0-9]+) (.*)$/i",
						$text,
						$m
					);
					$count = $m[2];
					$txt = $m[3];
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "» ғʟᴏᴏᴅɪɴɢ ᴛᴇxᴛ ( `$txt` ) ᴄᴏᴜɴᴛ ( `$count` ) . . . !",
						"parse_mode" => "markdown",
					]);
					for ($i = 1; $i <= $count; $i++) {
						yield $this->messages->sendMessage([
							"peer" => $peer,
							"message" => $txt,
						]);
					}
				}
				//================ Cleaner ================
				if ($text == "clean all" or $text == "پاکسازی کلی") {
					if ($type3 == "supergroup" || $type3 == "chat") {
						yield $this->messages->sendMessage([
							"peer" => $peer,
							"reply_to_msg_id" => $msg_id,
							"message" =>
								"[ᴀʟʟ ɢʀᴏᴜᴘ ᴍᴇssᴀɢᴇs ᴡᴇʀᴇ ᴅᴇʟᴇᴛᴇᴅ !](https://T.me/LegacySource)",
							"parse_mode" => "markdown",
							"disable_web_page_preview" => true,
						]);
						$array = range($msg_id, 1);
						$chunk = array_chunk($array, 100);
						foreach ($chunk as $v) {
							sleep(0.05);
							yield $this->channels->deleteMessages([
								"channel" => $peer,
								"id" => $v,
							]);
						}
					}
				}
				//================ Fall ================
				if ($text == "fal" or $text == "fall" or $text == "فال") {
					if (
						$type3 == "supergroup" ||
						$type3 == "chat" ||
						$type3 == "user"
					) {
						$add =
							"http://www.beytoote.com/images/Hafez/" .
							rand(1, 149) .
							".gif";
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" =>
								"» ɢᴇᴛᴛɪɴɢ ᴀ ᴏᴍᴇɴ ʜᴀғᴇᴢ ғᴏʀ ʏᴏᴜ . . . !",
							"parse_mode" => "MarkDown",
						]);
						$inputMediaPhotoExternal = [
							"_" => "inputMediaPhotoExternal",
							"url" => $add,
						];
						$this->messages->sendMedia([
							"peer" => $peer,
							"media" => $inputMediaPhotoExternal,
							"reply_to_msg_id" => $msg_id,
							"message" => "» ʏᴏᴜʀ ᴏᴍᴇɴ ʜᴀғᴇᴢ ɪs ʀᴇᴀᴅʏ =)",
						]);
					}
				}

				//================ Meaning ================
				if (
					preg_match("~^معنی (.+)~s", $text, $match) and
						($match = $match[1]) or
					preg_match("~^meane (.+)~s", $text, $match) and
						($match = $match[1])
				) {
					if (
						$type3 == "supergroup" ||
						$type3 == "chat" ||
						$type3 == "user"
					) {
						preg_match(
							'~<p class="">(.+?)</p>~si',
							file_get_contents(
								"https://www.vajehyab.com/?q=" .
									urlencode($match)
							),
							$p
						);
						$p = trim(
							strip_tags(
								preg_replace(
									[
										"~<[a-z0-9]+?>.+?</[a-z0-9]+?>|&.+?;~",
										"~<br.+?>~s",
									],
									["", "\n"],
									$p[1]
								)
							)
						);
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» ᴍᴇᴀɴɪɴɢ ( `$match` ) ғᴀʀsɪ ᴡᴏʀᴅ . . . !",
							"parse_mode" => "MarkDown",
						]);
						if ($p != null) {
							yield $this->messages->sendMessage([
								"peer" => $peer,
								"message" => "» کلمه اولیه : `$match`
» معنی :
» $p",
								"parse_mode" => "MarkDown",
								"reply_to_msg_id" => $msg_id,
							]);
						} else {
							yield $this->messages->sendMessage([
								"peer" => $peer,
								"message" => "» ʏᴏᴜʀ ᴡᴏʀᴅ ɴᴏᴛ ғᴏᴜɴᴅ !",
								"parse_mode" => "MarkDown",
								"reply_to_msg_id" => $msg_id,
							]);
						}
					}
				}
				//================ Git Hub ================
				if (preg_match("/^[\/\#\!]?(git) (.*)$/i", $text)) {
					preg_match("/^[\/\#\!]?(git) (.*)$/i", $text, $m);
					if (
						$type3 == "supergroup" ||
						$type3 == "chat" ||
						$type3 == "user"
					) {
						$mu = $m[2];
						$mu = str_replace("https://github.com/", "", $mu);
						$mu = str_replace("http://github.com/", "", $mu);
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» ɢᴇᴛᴛɪɴɢ ᴛʜᴇ ( `$mu` ) ɢɪᴛʜᴜʙ ғɪʟᴇ . . . ! ",
							"parse_mode" => "MarkDown",
						]);
						$rev =
							"https://github.com/" . $mu . "/archive/master.zip";
						$inputMediaDocumentExternal = [
							"_" => "inputMediaDocumentExternal",
							"url" => $rev,
						];
						$this->messages->sendMedia([
							"peer" => $peer,
							"media" => $inputMediaDocumentExternal,
							"reply_to_msg_id" => $msg_id,
							"message" => "» ʏᴏᴜʀ ɢɪᴛʜᴜʙ ғɪʟᴇ ɪs ʀᴇᴀᴅʏ =)",
						]);
					}
				}

				//================ Block & UnBlock ================
				if (
					$text == "unblock" or
					$text == "/unblock" or
					$text == "!unblock"
				) {
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
						yield $this->contacts->unblock(["id" => $messag]);
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» ᴜɴʙʟᴏᴄᴋᴇᴅ !",
						]);
					} else {
						if ($type3 == "user") {
							yield $this->contacts->unblock(["id" => $peer]);
							yield $this->messages->editMessage([
								"peer" => $peer,
								"id" => $msg_id,
								"message" => "» ᴜɴʙʟᴏᴄᴋᴇᴅ !",
							]);
						}
					}
				}

				if (
					$text == "block" or
					$text == "/block" or
					$text == "!block"
				) {
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
						yield $this->contacts->block(["id" => $messag]);
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» ʙʟᴏᴄᴋᴇᴅ !",
						]);
					} else {
						if ($type3 == "user") {
							yield $this->contacts->block(["id" => $peer]);
							yield $this->messages->editMessage([
								"peer" => $peer,
								"id" => $msg_id,
								"message" => "» ʙʟᴏᴄᴋᴇᴅ !",
							]);
						}
					}
				}
				//================ Reverse String ================
				if (preg_match("/^[\/\#\!]?(rev|معکوس) (.*)$/i", $text)) {
					preg_match("/^[\/\#\!]?(rev|معکوس) (.*)$/i", $text, $m);
					if (
						$type3 == "supergroup" ||
						$type3 == "chat" ||
						$type3 == "user"
					) {
						$mu = $m[2];
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» ʀᴇᴠᴇʀsɪɴɢ ᴛʜᴇ ( `$mu` ) ᴛᴇxᴛ . . . ! ",
							"parse_mode" => "MarkDown",
						]);
						$mu = str_replace(" ", "%20", $mu);
						$rev = file_get_contents(
							"https://api.codebazan.ir/strrev/?text=" . $mu
						);
						yield $this->messages->sendMessage([
							"peer" => $peer,
							"message" => $rev,
							"parse_mode" => "MarkDown",
							"reply_to_msg_id" => $msg_id,
						]);
					}
				}
				//================ Farsi Font Maker ================
				if (preg_match("/^[\/\#\!]?(fafont) (.*)$/i", $text)) {
					preg_match("/^[\/\#\!]?(fafont) (.*)$/i", $text, $m);
					if (
						$type3 == "supergroup" ||
						$type3 == "chat" ||
						$type3 == "user"
					) {
						$matn = strtoupper("$m[2]");
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» ʙᴜɪʟᴅɪɴɢ 10 ғᴀʀsɪ ғᴏɴᴛs ғᴏʀ ( `$m[2]` ) ɴᴀᴍᴇ . . . ! ",
							"parse_mode" => "MarkDown",
						]);
						$fa = [
							"آ",
							"ا",
							"ب",
							"پ",
							"ت",
							"ث",
							"ج",
							"چ",
							"ح",
							"خ",
							"د",
							"ذ",
							"ر",
							"ز",
							"ژ",
							"س",
							"ش",
							"ص",
							"ض",
							"ط",
							"ظ",
							"ع",
							"غ",
							"ف",
							"ق",
							"ک",
							"گ",
							"ل",
							"م",
							"ن",
							"و",
							"ه",
							"ی",
						];
						$_a = [
							"آ",
							"اَِ",
							"بَِ",
							"پَِـَِـ",
							"تَِـ",
							"ثَِ",
							"جَِ",
							"چَِ",
							"حَِـَِ",
							"خَِ",
							"دَِ",
							"ذَِ",
							"رَِ",
							"زَِ",
							"ژَِ",
							"سَِــَِ",
							"شَِـَِ",
							"صَِ",
							"ضَِ",
							"طَِ",
							"ظَِ",
							"عَِ",
							"غَِ",
							"فَِ",
							"قَِ",
							"ڪَِــ",
							"گَِــ",
							"لَِ",
							"مَِــَِ",
							"نَِ",
							"وَِ",
							"هَِ",
							"یَِ",
						];
						$_b = [
							"آ",
							"ا",
							"بـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜ",
							"پـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜ",
							"تـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜ",
							"ثـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜ",
							"جـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜ",
							"چـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜ",
							"حـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜ‌",
							"خـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜ",
							"د۪ٜ",
							"ذ۪ٜ",
							"ر۪ٜ",
							"ز۪ٜ‌",
							"ژ۪ٜ",
							"سـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜ‌",
							"شـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜ",
							"صـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜ",
							"ضـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜ",
							"طـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜ‌",
							"ظـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜ",
							"عـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜ‌",
							"غـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜ",
							"فـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜ",
							"قـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜ‌",
							"کـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜ",
							"گـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜ‌",
							"لـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜ‌",
							"مـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜ‌",
							"نـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜ",
							"و",
							"هـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜ",
							"یـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜـ۪ٜ",
						];
						$_c = [
							"آ",
							"ا",
							"بـــ",
							"پــ",
							"تـــ",
							"ثــ",
							"جــ",
							"چــ",
							"حــ",
							"خــ",
							"دّ",
							"ذّ",
							"رّ",
							"زّ",
							"ژّ",
							"ســ",
							"شــ",
							"صــ",
							"ضــ",
							"طــ",
							"ظــ",
							"عــ",
							"غــ",
							"فــ",
							"قــ",
							"کــ",
							"گــ",
							"لــ",
							"مـــ",
							"نـــ",
							"وّ",
							"هــ",
							"یـــ",
						];
						$_d = [
							"آ",
							"ا",
							"بـ﹏ـ",
							"پـ﹏ـ",
							"تـ﹏ـ",
							"ثـ﹏ــ",
							"جـ﹏ــ",
							"چـ﹏ـ",
							"حـ﹏ـ",
							"خـ﹏ـ",
							"د",
							"ذ",
							"ر",
							"ز",
							"ژ",
							"سـ﹏ـ",
							"شـ﹏ـ",
							"صـ﹏ــ",
							"ضـ﹏ـ",
							"طـ﹏ـ",
							"ظـ﹏ــ",
							"عـ﹏ـ",
							"غـ﹏ـ",
							"فـ﹏ـ",
							"قـ﹏ـ",
							"کـ﹏ـ",
							"گـ﹏ـ",
							"لـ﹏ــ",
							"مـ﹏ـ",
							"نـ﹏ـ",
							"و",
							"هـ﹏ـ",
							"یـ﹏ـ",
						];
						$_e = [
							"آ",
							"ا",
							"ب̈́ـ̈́ـ̈́ـ̈́ـ",
							"پ̈́ـ̈́ـ̈́ـ̈́ـ",
							"ت̈́ـ̈́ـ̈́ـ̈́ـ",
							"ث̈́ـ̈́ـ̈́ـ̈́ـ",
							"ج̈́ـ̈́ـ̈́ـ̈́ـ",
							"چـ̈́ـ̈́ـ̈́ـ",
							"ح̈́ـ̈́ـ̈́ـ̈́ـ",
							"خـ̈́ـ̈́ـ̈́ـ",
							"د",
							"ذ",
							"ر",
							"ز",
							"ژ",
							"سـ̈́ـ̈́ـ̈́ـ",
							"شـ̈́ـ̈́ـ̈́ـ",
							"ص̈́ـ̈́ـ̈́ـ̈́ـ",
							"ض̈́ـ̈́ـ̈́ـ̈́ـ",
							"ط̈́ـ̈́ـ̈́ـ̈́ـ",
							"ظـ̈́ـ̈́ـ̈́ـ̈́ـ",
							"ع̈́ـ̈́ـ̈́ـ̈́ـ",
							"غ̈́ـ̈́ـ̈́ـ̈́ـ",
							"فـ̈́ـ̈́ـ̈́ـ̈́ـ",
							"قـ̈́ـ̈́ـ̈́ـ",
							"کـ̈́ـ̈́ـ̈́ـ",
							"گـ̈́ـ̈́ـ̈́ـ̈́ـ",
							"ل̈́ـ̈́ـ̈́ـ̈́ـ",
							"م̈́ـ̈́ـ̈́ـ̈́ـ",
							"ن̈́ـ̈́ـ̈́ـ̈́ـ",
							"و",
							"ه̈́ـ̈́ـ̈́ـ̈́ـ",
							"ی̈́ـ̈́ـ̈́ـ̈́ـ",
						];
						$_f = [
							"آ",
							"اؒؔ",
							"بـ͜͡ــؒؔـ͜͝ـ",
							"پـ͜͡ــؒؔـ͜͝ـ",
							"تـ͜͡ــؒؔـ͜͝ـ",
							"ثـ͜͡ــؒؔـ͜͝ـ",
							"جـ͜͡ــؒؔـ͜͝ـ",
							"چـ͜͡ــؒؔـ͜͝ـ",
							"حـ͜͡ــؒؔـ͜͝ـ",
							"خـ͜͡ــؒؔـ͜͝ـ",
							"د۠۠",
							"ذ",
							"ر",
							"ز",
							"ژ",
							"سـ͜͡ــؒؔـ͜͝ـ",
							"شـ͜͡ــؒؔـ͜͝ـ",
							"صـ͜͡ــؒؔـ͜͝ـ",
							"ضـ͜͡ــؒؔـ͜͝ـ",
							"طـ͜͡ــؒؔـ͜͝ـ",
							"ظـ͜͡ــؒؔـ͜͝ـ",
							"عـ͜͡ــؒؔـ͜͝ـ",
							"غـ͜͡ــؒؔـ͜͝ـ",
							"فـ͜͡ــؒؔـ͜͝ـ",
							"قـ͜͡ــؒؔـ͜͝ـ",
							"کـ͜͡ــؒؔـ͜͝ـ",
							"گـ͜͡ــؒؔـ͜͝ـ",
							"لـ͜͡ــؒؔـ͜͝ـ",
							"مـ͜͡ــؒؔـ͜͝ـ",
							"نـ͜͡ــؒؔـ͜͝ـ",
							"وۘۘ",
							"هـ͜͡ــؒؔـ͜͝ـ",
							"یـ͜͡ــؒؔـ͜͝ـ",
						];
						$_g = [
							"❀آ",
							"ا",
							"بـैـ۪ٜـ۪ٜـ۪ٜ❀͜͡ــؒؔ",
							"پـैـ۪ٜـ۪ٜـ۪ٜ❀͜͡ــؒؔ",
							"تـैـ۪ٜـ۪ٜـ۪ٜ❀͜͡ــؒؔ",
							"ثـैـ۪ٜـ۪ٜـ۪ٜ❀͜͡ــؒؔ",
							"جـैـ۪ٜـ۪ٜـ۪ٜ❀͜͡ــؒؔ",
							"چـैـ۪ٜـ۪ٜـ۪ٜ❀͜͡ــؒؔ",
							"حैـ۪ٜـ۪ٜـ۪ٜ❀͜͡ــؒؔ",
							"خـैـ۪ٜـ۪ٜـ۪ٜ❀͜͡ــ",
							"❀د",
							"ذै",
							"رؒؔ",
							"ز۪ٜ❀",
							"❀ژै",
							"سـैـ۪ٜـ۪ٜـ۪ٜ❀͜͡ــؒؔ",
							"شـैـ۪ٜـ۪ٜـ۪ٜ❀͜͡ــؒؔ",
							"صैـ۪ٜـ۪ٜـ۪ٜ❀͜͡ــؒؔ",
							"ضैـ۪ٜـ۪ٜـ۪ٜ❀͜͡ــؒؔ",
							"طैـ۪ٜـ۪ٜـ۪ٜ❀͜͡ــؒؔ",
							"ظैـ۪ٜـ۪ٜـ۪ٜ❀͜͡ــؒؔ",
							"عـैـ۪ٜـ۪ٜـ۪ٜ❀͜͡ــؒؔ",
							"غـैـ۪ٜـ۪ٜـ۪ٜ❀͜͡ــؒؔ",
							"فـैـ۪ٜـ۪ٜـ۪ٜ❀͜͡ــؒؔ",
							"قـैـ۪ٜـ۪ٜـ۪ٜ❀͜͡ــؒؔ",
							"ڪैـ۪ٜـ۪ٜـ۪ٜ❀͜͡ــؒؔ",
							"گـैـ۪ٜـ۪ٜـ۪ٜ❀͜͡ــؒؔ",
							"لـैـ۪ٜـ۪ٜـ۪ٜ❀͜͡ــؒؔ",
							"مـैـ۪ٜـ۪ٜـ۪ٜ❀͜͡ــؒؔ",
							"نـैـ۪ٜـ۪ٜـ۪ٜ❀͜͡ــؒؔ",
							"وَّ",
							"هـैـ۪ٜـ۪ٜـ۪ٜ❀͜͡ــؒؔ",
							"یـैـ۪ٜـ۪ٜـ۪ٜ❀͜͡ــؒؔ",
						];
						$_h = [
							"آٰٖـٰٖ℘ـَ͜✾ـ",
							"اٰٖـٰٖ℘ـَ͜✾ـ",
							"بٰٖـٰٖ℘ـَ͜✾ـ",
							"پٰٖـٰٖ℘ـَ͜✾ـ",
							"تٰٖـٰٖ℘ـَ͜✾ـ",
							"ثٰٖـٰٖ℘ـَ͜✾ـ",
							"جٰٖـٰٖ℘ـَ͜✾ـ",
							"چٰٖـٰٖ℘ـَ͜✾ـ",
							"حٰٖـٰٖ℘ـَ͜✾ـ",
							"خٰٖـٰٖ℘ـَ͜✾ـ",
							"دٰٖـٰٖ℘ـَ͜✾ـ",
							"ذٰٖـٰٖ℘ـَ͜✾ـ",
							"رٰٖـٰٖ℘ـَ͜✾ـ",
							"زٰٖـٰٖ℘ـَ͜✾ـ",
							"ژٰٖـٰٖ℘ـَ͜✾ـ",
							"سٰٖـٰٖ℘ـَ͜✾ـ",
							"شٰٖـٰٖ℘ـَ͜✾ـ",
							"صٰٖـٰٖ℘ـَ͜✾ـ",
							"ضٰٖـٰٖ℘ـَ͜✾ـ",
							"طٰٖـٰٖ℘ـَ͜✾ـ",
							"ظٰٖـٰٖ℘ـَ͜✾ـ",
							"عٰٖـٰٖ℘ـَ͜✾ـ",
							"غٰٖـٰٖ℘ـَ͜✾ـ",
							"فٰٖـٰٖ℘ـَ͜✾ـ",
							"قٰٖـٰٖ℘ـَ͜✾ـ",
							"کٰٖـٰٖ℘ـَ͜✾ـ",
							"گٰٖـٰٖ℘ـَ͜✾ـ",
							"لٰٖـٰٖ℘ـَ͜✾ـ",
							"مٰٖـٰٖ℘ـَ͜✾ـ",
							"نٰٖـٰٖ℘ـَ͜✾ـ",
							"وٰٖـٰٖ℘ـَ͜✾ـ",
							"هٰٖـٰٖ℘ـَ͜✾ـ",
							"یٰٖـٰٖ℘ـَ͜✾ـ",
						];
						$_i = [
							"آ✺۠۠➤",
							"ا✺۠۠➤",
							"بـ͜͝ـ͜͝ـ͜͝ـ✺۠۠➤",
							"پـ͜͝ـ͜͝ـ͜͝ـ✺۠۠➤",
							"تـ͜͝ـ͜͝ـ͜͝ـ✺۠۠➤",
							"ث✺۠۠➤",
							"جـ͜͝ـ͜͝ـ͜͝ـ✺۠۠➤",
							"چـ͜͝ـ͜͝ـ͜͝ـ✺۠۠➤",
							"حـ͜͝ـ͜͝ـ͜͝ـ✺۠۠➤",
							"خـ͜͝ـ͜͝ـ͜͝ـ✺۠۠➤",
							"د✺۠۠➤",
							"ذ✺۠۠➤",
							"ر✺۠۠➤",
							"ز✺۠۠➤",
							"ژ✺۠۠➤",
							"سـ͜͝ـ͜͝ـ͜͝ـ✺۠۠➤",
							"شـ͜͝ـ͜͝ـ͜͝ـ✺۠۠➤",
							"صـ͜͝ـ͜͝ـ͜͝ـ✺۠۠➤",
							"ضـ͜͝ـ͜͝ـ͜͝ـ✺۠۠➤",
							"طـ͜͝ـ͜͝ـ͜͝ـ✺۠۠➤",
							"ظـ͜͝ـ͜͝ـ͜͝ـ✺۠۠➤",
							"عـ͜͝ـ͜͝ـ͜͝ـ✺۠۠➤",
							"غـ͜͝ـ͜͝ـ͜͝ـ✺۠۠➤",
							"فـ͜͝ـ͜͝ـ͜͝ـ✺۠۠➤",
							"قـ͜͝ـ͜͝ـ͜͝ـ✺۠۠➤",
							"کـ͜͝ـ͜͝ـ͜͝ـ✺۠۠➤",
							"گـ͜͝ـ͜͝ـ͜͝ـ✺۠۠➤",
							"لـ͜͝ـ͜͝ـ͜͝ـ✺۠۠➤",
							"مـ͜͝ـ͜͝ـ͜͝ـ✺۠۠➤",
							"نـ͜͝ـ͜͝ـ͜͝ـ✺۠۠➤",
							"و✺۠۠➤",
							"ه➤",
							"یـ͜͝ـ͜͝ـ͜͝ـ✺۠۠➤",
						];
						$_j = [
							"آ✭",
							"ا✭",
							"بـ͜͡ـ͜͡✭",
							"پـ͜͡ـ͜͡✭",
							"تـ͜͡ـ͜͡✭",
							"ثـ͜͡ـ͜͡ـ͜͡✭",
							"جـ͜͡ـ͜͡✭",
							"چــ͜͡ـ͜͡✭",
							"حـ͜͡ـ͜͡✭",
							"خــ͜͡ـ͜͡✭",
							"د✭",
							"ذ✭",
							"ر✭",
							"ز͜͡✭",
							"ـ͜͡ژ͜͡✭",
							"ســ͜͡ـ͜͡✭",
							"شـ͜͡ـ͜͡ـ͜͡✭",
							"صـ͜͡ـ͜͡✭",
							"ضـ͜͡ـ͜͡✭",
							"طـ͜͡ـ͜͡✭",
							"ظـ͜͡ـ͜͡✭",
							"عـ͜͡ـ͜͡✭",
							"غـ͜͡ـ͜͡✭",
							"فــ͜͡ـ͜͡✭",
							"قـ͜͡ـ͜͡ـ͜͡✭",
							"ڪــ͜͡ـ͜͡✭",
							"گـ͜͡ـ͜͡✭",
							"لـ͜͡ـ͜͡ـ͜͡✭",
							"مـ͜͡ـ͜͡ـ͜͡✭",
							"نـ͜͡ـ͜͡✭",
							"ـ͜͡و͜͡ـ͜͡✭",
							"هـ͜͡ـ͜͡ـ͜͡✭",
							"یـ͜͡ـ͜͡✭",
						];
						//========= Replace ==========
						$nn = str_replace($fa, $_a, $matn);
						$a = str_replace($fa, $_b, $matn);
						$b = str_replace($fa, $_c, $matn);
						$c = str_replace($fa, $_d, $matn);
						$d = str_replace($fa, $_e, $matn);
						$e = str_replace($fa, $_f, $matn);
						$f = str_replace($fa, $_g, $matn);
						$g = str_replace($fa, $_h, $matn);
						$h = str_replace($fa, $_i, $matn);
						$i = str_replace($fa, $_j, $matn);
						$readyfont = "
1 - `$nn`
2 - `$a`
3 - `$b`
4 - `$c`
5 - `$d`
6 - `$e`
7 - `$f`
8 - `$g`
9 - `$h`
10 - `$i`";
						yield $this->messages->sendMessage([
							"peer" => $peer,
							"message" => "$readyfont

» ʏᴏᴜʀ ғᴀʀsɪ ғᴏɴᴛs ɪs ʀᴇᴀᴅʏ. ᴛᴏᴜᴄʜ ᴛᴏ ᴄᴏᴘʏ !",
							"parse_mode" => "markdown",
							"reply_to_msg_id" => $msg_id,
						]);
					}
				}
				//============= Currency prices ==============
				if ($text == "arz" or $text == "ارز") {
					if (
						$type3 == "supergroup" ||
						$type3 == "chat" ||
						$type3 == "user"
					) {
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» ɢᴇᴛᴛɪɴɢ ᴄᴜʀʀᴇɴᴄʏ ᴘʀɪᴄᴇs . . . !",
							"parse_mode" => "MarkDown",
						]);
						$arz = json_decode(
							file_get_contents("https://r2f.ir/web/arz.php"),
							true
						);
						$yoro = $arz["0"]["price"];
						$emarat = $arz["1"]["price"];
						$swead = $arz["2"]["price"];
						$norway = $arz["3"]["price"];
						$iraq = $arz["4"]["price"];
						$swit = $arz["5"]["price"];
						$armanestan = $arz["6"]["price"];
						$gorgea = $arz["7"]["price"];
						$pakestan = $arz["8"]["price"];
						$soudi = $arz["9"]["price"];
						$russia = $arz["10"]["price"];
						$india = $arz["11"]["price"];
						$kwait = $arz["12"]["price"];
						$astulia = $arz["13"]["price"];
						$oman = $arz["14"]["price"];
						$qatar = $arz["15"]["price"];
						$kanada = $arz["16"]["price"];
						$tailand = $arz["17"]["price"];
						$turkye = $arz["18"]["price"];
						$england = $arz["19"]["price"];
						$hong = $arz["20"]["price"];
						$azarbayjan = $arz["21"]["price"];
						$malezy = $arz["22"]["price"];
						$danmark = $arz["23"]["price"];
						$newzland = $arz["24"]["price"];
						$china = $arz["25"]["price"];
						$japan = $arz["26"]["price"];
						$bahrin = $arz["27"]["price"];
						$souria = $arz["28"]["price"];
						$dolar = $arz["29"]["price"];
						$talaa = json_decode(
							file_get_contents("https://r2f.ir/web/tala.php"),
							true
						);
						$tala = $talaa["4"]["price"];
						$nogre = $talaa["5"]["price"];
						$emami = $talaa["0"]["price"];
						$nim = $talaa["1"]["price"];
						$rob = $talaa["2"]["price"];
						$geram = $talaa["3"]["price"];
						$bahar = $talaa["6"]["price"];
						$get = file_get_contents(
							"http://api.novateamco.ir/arz/"
						);
						$result = json_decode($get, true);
						$tala24 = $result["Gold_24"];
						$tala18 = $result["Gold_18"];
						$prckol = "
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» قیمت ارز کشور های مختلف دنیا :
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» یورو : `$yoro` ريال
➖➖➖➖➖
» دلار : `$dolar` ريال
➖➖➖➖➖
» درهم امارات  : `$emarat` ريال
➖➖➖➖➖
» کرون سوئد : `$swead` ريال
➖➖➖➖➖
» کرون نروژ : `$norway` ريال
➖➖➖➖➖
» دینار عراق : `$iraq` ريال
➖➖➖➖➖
» فرانک سوئیس : `$swit` ريال
➖➖➖➖➖
» درام ارمنستان : `$armanestan` ريال
➖➖➖➖➖
» لاری گرجستان : `$gorgea` ريال
➖➖➖➖➖
» روپیه پاکستان : `$pakestan` ريال
➖➖➖➖➖
» روبل روسیه : `$russia` ريال
➖➖➖➖➖
» روپیه هندوستان : `$india` ريال
➖➖➖➖➖
» دینار کویت : `$kwait` ريال
➖➖➖➖➖
» دلار استرلیا : `$astulia` ريال
➖➖➖➖➖
» ریال عمان : `$oman` ريال
➖➖➖➖➖
» ریال قطر : `$qatar` ريال
➖➖➖➖➖
» دلار کانادا : `$kanada` ريال
➖➖➖➖➖
» بات تایلند : `$tailand` ريال
➖➖➖➖➖
» لیر ترکیه : `$turkye` ريال
➖➖➖➖➖
» پوند انگلیس : `$england` ريال
➖➖➖➖➖
» دلار هنگ کنگ : `$hong` ريال
➖➖➖➖➖
» منات اذربایجان : `$azarbayjan` ريال
➖➖➖➖➖
» مالزی : `$malezy` ريال
➖➖➖➖➖
» کرون دانمارک : `$danmark` ريال
➖➖➖➖➖
» دلار نیوزلند : `$newzland` ريال
➖➖➖➖➖
» یوان چین : `$china`  ريال
➖➖➖➖➖
» ین ژآپن : `$japan` ريال
➖➖➖➖➖
» دینار بحرین : `$bahrin` ريال
➖➖➖➖➖
» لیر سوریه : `$souria` ريال
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» قیمت انواع سکه :
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» سکه گرمی : `$geram` ريال
➖➖➖➖➖
» ربع سکه : `$rob` ريال
➖➖➖➖➖
» نیم سکه : `$nim` ريال
➖➖➖➖➖
» سکه بهار آزادی : `$bahar` ريال
➖➖➖➖➖
» سکه امامی : `$emami` ريال
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» قیمت طلا :
=-=-=-=-=-=-=-=-=-=-=-=-=-=
» طلای 24 عیار : `$tala24` ريال
➖➖➖➖➖
» طلای 18 عیار : `$tala18` ريال
=-=-=-=-=-=-=-=-=-=-=-=-=-=
";
						yield $this->messages->sendMessage([
							"peer" => $peer,
							"message" => $prckol,
							"parse_mode" => "markdown",
							"reply_to_msg_id" => $msg_id,
						]);
					}
				}

				//================ Font Maker ================
				if (preg_match("/^[\/\#\!]?(font) (.*)$/i", $text)) {
					preg_match("/^[\/\#\!]?(font) (.*)$/i", $text, $m);
					if (
						$type3 == "supergroup" ||
						$type3 == "chat" ||
						$type3 == "user"
					) {
						$matn = strtoupper("$m[2]");
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» ʙᴜɪʟᴅɪɴɢ 125 ғᴏɴᴛs ғᴏʀ ( `$m[2]` ) ɴᴀᴍᴇ . . . ! ",
							"parse_mode" => "MarkDown",
						]);
						$mu = str_replace(" ", "%20", $m[2]);
						$fontss = file_get_contents(
							"https://api.codebazan.ir/font/?text=" . $mu
						);
						$fontha = json_decode($fontss, true);
						$result = $fontha["result"];

						$Eng = [
							"Q",
							"W",
							"E",
							"R",
							"T",
							"Y",
							"U",
							"I",
							"O",
							"P",
							"A",
							"S",
							"D",
							"F",
							"G",
							"H",
							"J",
							"K",
							"L",
							"Z",
							"X",
							"C",
							"V",
							"B",
							"N",
							"M",
						];
						$Font_0 = [
							"𝐐",
							"𝐖",
							"𝐄",
							"𝐑",
							"𝐓",
							"𝐘",
							"𝐔",
							"𝐈",
							"𝐎",
							"𝐏",
							"𝐀",
							"𝐒",
							"𝐃",
							"𝐅",
							"𝐆",
							"𝐇",
							"𝐉",
							"𝐊",
							"𝐋",
							"𝐙",
							"𝐗",
							"𝐂",
							"𝐕",
							"𝐁",
							"𝐍",
							"𝐌",
						];
						$Font_1 = [
							"𝑸",
							"𝑾",
							"𝑬",
							"𝑹",
							"𝑻",
							"𝒀",
							"𝑼",
							"𝑰",
							"𝑶",
							"𝑷",
							"𝑨",
							"𝑺",
							"𝑫",
							"𝑭",
							"𝑮",
							"𝑯",
							"𝑱",
							"𝑲",
							"𝑳",
							"𝒁",
							"𝑿",
							"𝑪",
							"𝑽",
							"𝑩",
							"𝑵",
							"𝑴",
						];
						$Font_2 = [
							"𝑄",
							"𝑊",
							"𝐸",
							"𝑅",
							"𝑇",
							"𝑌",
							"𝑈",
							"𝐼",
							"𝑂",
							"𝑃",
							"𝐴",
							"𝑆",
							"𝐷",
							"𝐹",
							"𝐺",
							"𝐻",
							"𝐽",
							"𝐾",
							"𝐿",
							"𝑍",
							"𝑋",
							"𝐶",
							"𝑉",
							"𝐵",
							"𝑁",
							"𝑀",
						];
						$Font_3 = [
							"𝗤",
							"𝗪",
							"𝗘",
							"𝗥",
							"𝗧",
							"𝗬",
							"𝗨",
							"𝗜",
							"𝗢",
							"𝗣",
							"𝗔",
							"𝗦",
							"𝗗",
							"𝗙",
							"𝗚",
							"𝗛",
							"𝗝",
							"𝗞",
							"𝗟",
							"𝗭",
							"𝗫",
							"𝗖",
							"𝗩",
							"𝗕",
							"𝗡",
							"𝗠",
						];
						$Font_4 = [
							"𝖰",
							"𝖶",
							"𝖤",
							"𝖱",
							"𝖳",
							"𝖸",
							"𝖴",
							"𝖨",
							"𝖮",
							"𝖯",
							"𝖠",
							"𝖲",
							"𝖣",
							"𝖥",
							"𝖦",
							"𝖧",
							"𝖩",
							"𝖪",
							"𝖫",
							"𝖹",
							"𝖷",
							"𝖢",
							"𝖵",
							"𝖡",
							"𝖭",
							"𝖬",
						];
						$Font_5 = [
							"𝕼",
							"𝖂",
							"𝕰",
							"𝕽",
							"𝕵",
							"𝚼",
							"𝖀",
							"𝕿",
							"𝕺",
							"𝕻",
							"𝕬",
							"𝕾",
							"𝕯",
							"𝕱",
							"𝕲",
							"𝕳",
							"𝕴",
							"𝕶",
							"𝕷",
							"𝖅",
							"𝖃",
							"𝕮",
							"𝖁",
							"𝕭",
							"𝕹",
							"𝕸",
						];
						$Font_6 = [
							"𝔔",
							"𝔚",
							"𝔈",
							"ℜ",
							"𝔍",
							"ϒ",
							"𝔘",
							"𝔗",
							"𝔒",
							"𝔓",
							"𝔄",
							"𝔖",
							"𝔇",
							"𝔉",
							"𝔊",
							"ℌ",
							"ℑ",
							"𝔎",
							"𝔏",
							"ℨ",
							"𝔛",
							"ℭ",
							"𝔙",
							"𝔅",
							"𝔑",
							"𝔐",
						];
						$Font_7 = [
							"𝙌",
							"𝙒",
							"𝙀",
							"𝙍",
							"𝙏",
							"𝙔",
							"𝙐",
							"𝙄",
							"𝙊",
							"𝙋",
							"𝘼",
							"𝙎",
							"𝘿",
							"𝙁",
							"𝙂",
							"𝙃",
							"𝙅",
							"𝙆",
							"𝙇",
							"𝙕",
							"𝙓",
							"𝘾",
							"𝙑",
							"𝘽",
							"𝙉",
							"𝙈",
						];
						$Font_8 = [
							"𝘘",
							"𝘞",
							"𝘌",
							"𝘙",
							"𝘛",
							"𝘠",
							"𝘜",
							"𝘐",
							"𝘖",
							"𝘗",
							"𝘈",
							"𝘚",
							"𝘋",
							"𝘍",
							"𝘎",
							"𝘏",
							"𝘑",
							"𝘒",
							"𝘓",
							"𝘡",
							"𝘟",
							"𝘊",
							"𝘝",
							"𝘉",
							"𝘕",
							"𝘔",
						];
						$Font_9 = [
							"Q̶̶",
							"W̶̶",
							"E̶̶",
							"R̶̶",
							"T̶̶",
							"Y̶̶",
							"U̶̶",
							"I̶̶",
							"O̶̶",
							"P̶̶",
							"A̶̶",
							"S̶̶",
							"D̶̶",
							"F̶̶",
							"G̶̶",
							"H̶̶",
							"J̶̶",
							"K̶̶",
							"L̶̶",
							"Z̶̶",
							"X̶̶",
							"C̶̶",
							"V̶̶",
							"B̶̶",
							"N̶̶",
							"M̶̶",
						];
						$Font_10 = [
							"Q̷̷",
							"W̷̷",
							"E̷̷",
							"R̷̷",
							"T̷̷",
							"Y̷̷",
							"U̷̷",
							"I̷̷",
							"O̷̷",
							"P̷̷",
							"A̷̷",
							"S̷̷",
							"D̷̷",
							"F̷̷",
							"G̷̷",
							"H̷̷",
							"J̷̷",
							"K̷̷",
							"L̷̷",
							"Z̷̷",
							"X̷̷",
							"C̷̷",
							"V̷̷",
							"B̷̷",
							"N̷̷",
							"M̷̷",
						];
						$Font_11 = [
							"Q͟͟",
							"W͟͟",
							"E͟͟",
							"R͟͟",
							"T͟͟",
							"Y͟͟",
							"U͟͟",
							"I͟͟",
							"O͟͟",
							"P͟͟",
							"A͟͟",
							"S͟͟",
							"D͟͟",
							"F͟͟",
							"G͟͟",
							"H͟͟",
							"J͟͟",
							"K͟͟",
							"L͟͟",
							"Z͟͟",
							"X͟͟",
							"C͟͟",
							"V͟͟",
							"B͟͟",
							"N͟͟",
							"M͟͟",
						];
						$Font_12 = [
							"Q͇͇",
							"W͇͇",
							"E͇͇",
							"R͇͇",
							"T͇͇",
							"Y͇͇",
							"U͇͇",
							"I͇͇",
							"O͇͇",
							"P͇͇",
							"A͇͇",
							"S͇͇",
							"D͇͇",
							"F͇͇",
							"G͇͇",
							"H͇͇",
							"J͇͇",
							"K͇͇",
							"L͇͇",
							"Z͇͇",
							"X͇͇",
							"C͇͇",
							"V͇͇",
							"B͇͇",
							"N͇͇",
							"M͇͇",
						];
						$Font_13 = [
							"Q̤̤",
							"W̤̤",
							"E̤̤",
							"R̤̤",
							"T̤̤",
							"Y̤̤",
							"Ṳ̤",
							"I̤̤",
							"O̤̤",
							"P̤̤",
							"A̤̤",
							"S̤̤",
							"D̤̤",
							"F̤̤",
							"G̤̤",
							"H̤̤",
							"J̤̤",
							"K̤̤",
							"L̤̤",
							"Z̤̤",
							"X̤̤",
							"C̤̤",
							"V̤̤",
							"B̤̤",
							"N̤̤",
							"M̤̤",
						];
						$Font_14 = [
							"Q̰̰",
							"W̰̰",
							"Ḛ̰",
							"R̰̰",
							"T̰̰",
							"Y̰̰",
							"Ṵ̰",
							"Ḭ̰",
							"O̰̰",
							"P̰̰",
							"A̰̰",
							"S̰̰",
							"D̰̰",
							"F̰̰",
							"G̰̰",
							"H̰̰",
							"J̰̰",
							"K̰̰",
							"L̰̰",
							"Z̰̰",
							"X̰̰",
							"C̰̰",
							"V̰̰",
							"B̰̰",
							"N̰̰",
							"M̰̰",
						];
						$Font_15 = [
							"디",
							"山",
							"乇",
							"尺",
							"亇",
							"丫",
							"凵",
							"工",
							"口",
							"ㄗ",
							"闩",
							"丂",
							"刀",
							"下",
							"彑",
							"⼶",
							"亅",
							"片",
							"乚",
							"乙",
							"乂",
							"亡",
							"ム",
							"乃",
							"力",
							"从",
						];
						$Font_16 = [
							"ዓ",
							"ሠ",
							"ይ",
							"ዩ",
							"ፐ",
							"ሃ",
							"ሀ",
							"ፗ",
							"ዐ",
							"የ",
							"ል",
							"ና",
							"ሏ",
							"ፑ",
							"ፘ",
							"ዘ",
							"ጋ",
							"ኸ",
							"ረ",
							"ጓ",
							"ጰ",
							"ር",
							"ህ",
							"ፎ",
							"በ",
							"ጠ",
						];
						$Font_17 = [
							"Ꭷ",
							"Ꮃ",
							"Ꭼ",
							"Ꮢ",
							"Ꭲ",
							"Ꭹ",
							"Ꮜ",
							"Ꮖ",
							"Ꮻ",
							"Ꮲ",
							"Ꭺ",
							"Ꮪ",
							"Ꭰ",
							"Ꮀ",
							"Ꮐ",
							"Ꮋ",
							"Ꭻ",
							"Ꮶ",
							"Ꮮ",
							"Ꮓ",
							"Ꮱ",
							"Ꮯ",
							"Ꮩ",
							"Ᏼ",
							"N",
							"Ꮇ",
						];
						$Font_18 = [
							"Ǫ",
							"Ѡ",
							"Σ",
							"Ʀ",
							"Ϯ",
							"Ƴ",
							"Ʋ",
							"Ϊ",
							"Ѳ",
							"Ƥ",
							"Ѧ",
							"Ƽ",
							"Δ",
							"Ӻ",
							"Ǥ",
							"ⴼ",
							"Ɉ",
							"Ҟ",
							"Ɫ",
							"Ⱬ",
							"Ӽ",
							"Ҁ",
							"Ѵ",
							"Ɓ",
							"Ɲ",
							"ᛖ",
						];
						$Font_19 = [
							"ꐎ",
							"ꅐ",
							"ꂅ",
							"ꉸ",
							"ꉢ",
							"ꌦ",
							"ꏵ",
							"ꀤ",
							"ꏿ",
							"ꉣ",
							"ꁲ",
							"ꌗ",
							"ꅓ",
							"ꊰ",
							"ꁅ",
							"ꍬ",
							"ꀭ",
							"ꂪ",
							"꒒",
							"ꏣ",
							"ꉧ",
							"ꊐ",
							"ꏝ",
							"ꃃ",
							"ꊮ",
							"ꂵ",
						];
						$Font_20 = [
							"ᘯ",
							"ᗯ",
							"ᕮ",
							"ᖇ",
							"ᙢ",
							"ᖻ",
							"ᑌ",
							"ᖗ",
							"ᗝ",
							"ᑭ",
							"ᗩ",
							"ᔕ",
							"ᗪ",
							"ᖴ",
							"ᘜ",
							"ᕼ",
							"ᒍ",
							"ᖉ",
							"ᒐ",
							"ᘔ",
							"᙭",
							"ᑕ",
							"ᕓ",
							"ᗷ",
							"ᘉ",
							"ᗰ",
						];
						$Font_21 = [
							"ᑫ",
							"ᗯ",
							"ᗴ",
							"ᖇ",
							"Ꭲ",
							"Ꭹ",
							"ᑌ",
							"Ꮖ",
							"ᝪ",
							"ᑭ",
							"ᗩ",
							"ᔑ",
							"ᗞ",
							"ᖴ",
							"Ꮐ",
							"ᕼ",
							"ᒍ",
							"Ꮶ",
							"Ꮮ",
							"Ꮓ",
							"᙭",
							"ᑕ",
							"ᐯ",
							"ᗷ",
							"ᑎ",
							"ᗰ",
						];
						$Font_22 = [
							"ℚ",
							"Ꮤ",
							"℮",
							"ℜ",
							"Ƭ",
							"Ꮍ",
							"Ʋ",
							"Ꮠ",
							"Ꮎ",
							"⅌",
							"Ꭿ",
							"Ꮥ",
							"ⅅ",
							"ℱ",
							"Ꮹ",
							"ℋ",
							"ℐ",
							"Ӄ",
							"ℒ",
							"ℤ",
							"ℵ",
							"ℭ",
							"Ꮙ",
							"Ᏸ",
							"ℕ",
							"ℳ",
						];
						$Font_23 = [
							"Ԛ",
							"ᚠ",
							"ᛊ",
							"ᚱ",
							"ᛠ",
							"ᚴ",
							"ᛘ",
							"ᛨ",
							"θ",
							"ᚹ",
							"ᚣ",
							"ᛢ",
							"ᚦ",
							"ᚫ",
							"ᛩ",
							"ᚻ",
							"ᛇ",
							"ᛕ",
							"ᚳ",
							"Z",
							"ᚷ",
							"ᛈ",
							"ᛉ",
							"ᛒ",
							"ᚺ",
							"ᚥ",
						];
						$Font_24 = [
							"𝓠",
							"𝓦",
							"𝓔",
							"𝓡",
							"𝓣",
							"𝓨",
							"𝓤",
							"𝓘",
							"𝓞",
							"𝓟",
							"𝓐",
							"𝓢",
							"𝓓",
							"𝓕",
							"𝓖",
							"𝓗",
							"𝓙",
							"𝓚",
							"𝓛",
							"𝓩",
							"𝓧",
							"𝓒",
							"𝓥",
							"𝓑",
							"𝓝",
							"𝓜",
						];
						$Font_25 = [
							"𝒬",
							"𝒲",
							"ℰ",
							"ℛ",
							"𝒯",
							"𝒴",
							"𝒰",
							"ℐ",
							"𝒪",
							"𝒫",
							"𝒜",
							"𝒮",
							"𝒟",
							"ℱ",
							"𝒢",
							"ℋ",
							"??",
							"𝒦",
							"ℒ",
							"𝒵",
							"𝒳",
							"𝒞",
							"𝒱",
							"ℬ",
							"𝒩",
							"ℳ",
						];
						$Font_26 = [
							"ℚ",
							"??",
							"𝔼",
							"ℝ",
							"𝕋",
							"𝕐",
							"𝕌",
							"𝕀",
							"𝕆",
							"ℙ",
							"𝔸",
							"𝕊",
							"𝔻",
							"??",
							"𝔾",
							"ℍ",
							"𝕁",
							"𝕂",
							"𝕃",
							"ℤ",
							"𝕏",
							"ℂ",
							"𝕍",
							"𝔹",
							"ℕ",
							"𝕄",
						];
						$Font_27 = [
							"Ｑ",
							"Ｗ",
							"Ｅ",
							"Ｒ",
							"Ｔ",
							"Ｙ",
							"Ｕ",
							"Ｉ",
							"Ｏ",
							"Ｐ",
							"Ａ",
							"Ｓ",
							"Ｄ",
							"Ｆ",
							"Ｇ",
							"Ｈ",
							"Ｊ",
							"Ｋ",
							"Ｌ",
							"Ｚ",
							"Ｘ",
							"Ｃ",
							"Ｖ",
							"Ｂ",
							"Ｎ",
							"Ｍ",
						];
						$Font_28 = [
							"ǫ",
							"ᴡ",
							"ᴇ",
							"ʀ",
							"ᴛ",
							"ʏ",
							"ᴜ",
							"ɪ",
							"ᴏ",
							"ᴘ",
							"ᴀ",
							"s",
							"ᴅ",
							"ғ",
							"ɢ",
							"ʜ",
							"ᴊ",
							"ᴋ",
							"ʟ",
							"ᴢ",
							"x",
							"ᴄ",
							"ᴠ",
							"ʙ",
							"ɴ",
							"ᴍ",
						];
						$Font_29 = [
							"𝚀",
							"𝚆",
							"𝙴",
							"𝚁",
							"𝚃",
							"𝚈",
							"𝚄",
							"𝙸",
							"𝙾",
							"𝙿",
							"𝙰",
							"𝚂",
							"𝙳",
							"𝙵",
							"𝙶",
							"𝙷",
							"𝙹",
							"𝙺",
							"𝙻",
							"𝚉",
							"𝚇",
							"𝙲",
							"𝚅",
							"𝙱",
							"𝙽",
							"𝙼",
						];
						$Font_30 = [
							"ᵟ",
							"ᵂ",
							"ᴱ",
							"ᴿ",
							"ᵀ",
							"ᵞ",
							"ᵁ",
							"ᴵ",
							"ᴼ",
							"ᴾ",
							"ᴬ",
							"ˢ",
							"ᴰ",
							"ᶠ",
							"ᴳ",
							"ᴴ",
							"ᴶ",
							"ᴷ",
							"ᴸ",
							"ᶻ",
							"ˣ",
							"ᶜ",
							"ⱽ",
							"ᴮ",
							"ᴺ",
							"ᴹ",
						];
						$Font_31 = [
							"Ⓠ",
							"Ⓦ",
							"Ⓔ",
							"Ⓡ",
							"Ⓣ",
							"Ⓨ",
							"Ⓤ",
							"Ⓘ",
							"Ⓞ",
							"Ⓟ",
							"Ⓐ",
							"Ⓢ",
							"Ⓓ",
							"Ⓕ",
							"Ⓖ",
							"Ⓗ",
							"Ⓙ",
							"Ⓚ",
							"Ⓛ",
							"Ⓩ",
							"Ⓧ",
							"Ⓒ",
							"Ⓥ",
							"Ⓑ",
							"Ⓝ",
							"Ⓜ️",
						];
						$Font_32 = [
							"🅀",
							"🅆",
							"🄴",
							"🅁",
							"🅃",
							"🅈",
							"🅄",
							"🄸",
							"🄾",
							"🄿",
							"🄰",
							"🅂",
							"🄳",
							"🄵",
							"🄶",
							"🄷",
							"🄹",
							"🄺",
							"🄻",
							"🅉",
							"🅇",
							"🄲",
							"🅅",
							"🄱",
							"🄽",
							"🄼",
						];
						$Font_33 = [
							"🅠",
							"🅦",
							"🅔",
							"🅡",
							"🅣",
							"🅨",
							"🅤",
							"🅘",
							"🅞",
							"🅟",
							"🅐",
							"🅢",
							"🅓",
							"🅕",
							"🅖",
							"🅗",
							"🅙",
							"🅚",
							"🅛",
							"🅩 ",
							"🅧",
							"🅒",
							"🅥",
							"🅑",
							"🅝",
							"??",
						];
						$Font_34 = [
							"🆀",
							"🆆",
							"🅴",
							"🆁",
							"🆃",
							"🆈",
							"🆄",
							"🅸",
							"🅾️",
							"🅿️",
							"🅰️",
							"🆂",
							"🅳",
							"🅵",
							"🅶",
							"🅷",
							"🅹",
							"🅺",
							"🅻",
							"🆉",
							"🆇",
							"🅲",
							"🆅",
							"🅱️",
							"🅽",
							"🅼",
						];
						$Font_35 = [
							"🇶 ",
							"🇼 ",
							"🇪 ",
							"🇷 ",
							"🇹 ",
							"🇾 ",
							"🇺 ",
							"🇮 ",
							"🇴 ",
							"🇵 ",
							"🇦 ",
							"🇸 ",
							"🇩 ",
							"🇫 ",
							"🇬 ",
							"🇭 ",
							"🇯 ",
							"🇰 ",
							"🇱 ",
							"🇿 ",
							"🇽 ",
							"🇨 ",
							"🇻 ",
							"🇧 ",
							"🇳 ",
							"🇲 ",
						];
						//
						$nn = str_replace($Eng, $Font_0, $matn);
						$a = str_replace($Eng, $Font_1, $matn);
						$b = str_replace($Eng, $Font_2, $matn);
						$c = trim(str_replace($Eng, $Font_3, $matn));
						$d = str_replace($Eng, $Font_4, $matn);
						$e = str_replace($Eng, $Font_5, $matn);
						$f = str_replace($Eng, $Font_6, $matn);
						$g = str_replace($Eng, $Font_7, $matn);
						$h = str_replace($Eng, $Font_8, $matn);
						$i = str_replace($Eng, $Font_9, $matn);
						$j = str_replace($Eng, $Font_10, $matn);
						$k = str_replace($Eng, $Font_11, $matn);
						$l = str_replace($Eng, $Font_12, $matn);
						$m = str_replace($Eng, $Font_13, $matn);
						$n = str_replace($Eng, $Font_14, $matn);
						$o = str_replace($Eng, $Font_15, $matn);
						$p = str_replace($Eng, $Font_16, $matn);
						$q = str_replace($Eng, $Font_17, $matn);
						$r = str_replace($Eng, $Font_18, $matn);
						$s = str_replace($Eng, $Font_19, $matn);
						$t = str_replace($Eng, $Font_20, $matn);
						$u = str_replace($Eng, $Font_21, $matn);
						$v = str_replace($Eng, $Font_22, $matn);
						$w = str_replace($Eng, $Font_23, $matn);
						$x = str_replace($Eng, $Font_24, $matn);
						$y = str_replace($Eng, $Font_25, $matn);
						$z = str_replace($Eng, $Font_26, $matn);
						$aa = str_replace($Eng, $Font_27, $matn);
						$ac = str_replace($Eng, $Font_28, $matn);
						$ad = str_replace($Eng, $Font_29, $matn);
						$af = str_replace($Eng, $Font_30, $matn);
						$ag = str_replace($Eng, $Font_31, $matn);
						$ah = str_replace($Eng, $Font_32, $matn);
						$am = str_replace($Eng, $Font_33, $matn);
						$as = str_replace($Eng, $Font_34, $matn);
						$pol = str_replace($Eng, $Font_35, $matn);
						$readyfont = "1 - `$result[1]`
2 - `$result[2]`
3 - `$result[3]`
4 - `$result[4]`
5 - `$result[5]`
6 - `$result[6]`
7 - `$result[7]`
8 - `$result[8]`
9 - `$result[9]`
10 - `$result[10]`
11 - `$result[11]`
12 - `$result[12]`
13 - `$result[13]`
14 - `$result[14]`
15 - `$result[15]`
16 - `$result[16]`
17 - `$result[17]`
18 - `$result[18]`
19 - `$result[19]`
20 - `$result[20]`
21 - `$result[21]`
22 - `$result[22]`
23 - `$result[23]`
24 - `$result[24]`
25 - `$result[25]`
26 - `$result[26]`
27 - `$result[27]`
28 - `$result[28]`
29 - `$result[29]`
30 - `$result[30]`
31 - `$result[31]`
32 - `$result[32]`
33 - `$result[33]`
34 - `$result[34]`
35 - `$result[35]`
36 - `$result[36]`
37 - `$result[37]`
38 - `$result[38]`
39 - `$result[39]`
40 - `$result[40]`
41 - `$result[41]`
42 - `$result[42]`
43 - `$result[43]`
44 - `$result[44]`
45 - `$result[45]`
46 - `$result[46]`
47 - `$result[47]`
48 - `$result[48]`
49 - `$result[49]`
50 - `$result[50]`
51 - `$result[51]`
52 - `$result[52]`
53 - `$result[53]`
54 - `$result[54]`
55 - `$result[55]`
56 - `$result[56]`
57 - `$result[57]`
58 - `$result[58]`
59 - `$result[59]`
60 - `$result[60]`
61 - `$result[61]`
62 - `$result[62]`
63 - `$result[63]`
64 - `$result[64]`
65 - `$result[65]`
66 - `$result[66]`
67 - `$result[67]`
68 - `$result[68]`
69 - `$result[69]`
70 - `$result[70]`
71 - `$result[71]`
72 - `$result[72]`
73 - `$result[93]`
74 - `$result[74]`
75 - `$result[75]`
76 - `$result[76]`
77 - `$result[77]`
78 - `$result[78]`
79 - `$result[79]`
80 - `$result[80]`
81 - `$result[81]`
82 - `$result[82]`
83 - `$result[83]`
84 - `$result[84]`
85 - `$result[85]`
86 - `$result[86]`
87 - `$result[87]`
88 - `$result[88]`
89 - `$result[89]`
90 - `$result[90]`
91 - `$result[91]`
92 - `$result[92]`
93 - `$nn`
94 - `$a`
95 - `$b`
96 - `$c`
97 - `$d`
98 - `$e`
99 - `$f`
100 - `$g`
101 - `$h`
102 - `$i`
103 - `$j`
104 - `$k`
105 - `$l`
106 - `$m`
107 - `$n`
108 - `$o`
109 - `$p`
110 - `$q`
111 - `$r`
112 - `$s`
113 - `$t`
114 - `$u`
115 - `$v`
116 - `$w`
117 - `$x`
118 - `$z`
119 - `$aa`
120 - `$ac`
121 - `$ad`
122 - `$af`
123 - `$ah`
124 - `$am`
125 - `$pol`";
						yield $this->messages->sendMessage([
							"peer" => $peer,
							"message" => "$readyfont

» ʏᴏᴜʀ ғᴏɴᴛs ɪs ʀᴇᴀᴅʏ. ᴛᴏᴜᴄʜ ᴛᴏ ᴄᴏᴘʏ !",
							"parse_mode" => "markdown",
							"reply_to_msg_id" => $msg_id,
						]);
					}
				}
				//================ Apk ================
				if (preg_match("/^[\/\#\!]?(apk) (.*)$/i", $text)) {
					preg_match("/^[\/\#\!]?(apk) (.*)$/i", $text, $m);
					if (
						$type3 == "supergroup" ||
						$type3 == "chat" ||
						$type3 == "user"
					) {
						$mu = $m[2];
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» sᴇᴀʀᴄʜɪɴɢ ғᴏʀ ( `$m[2]` ) ᴀᴘᴋ . . . !",
							"parse_mode" => "markdown",
						]);
						$messages_BotResults = (yield $this->messages->getInlineBotResults(
							[
								"bot" => "@apkdl_bot",
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
				//================ Run Code ================
				if (stristr($text, "/php ") or stristr($text, "!php ")) {
					if (
						$type3 == "supergroup" ||
						$type3 == "chat" ||
						$type3 == "user"
					) {
						/*$text = str_replace(["/php", "!php"], ["/ php", "! php"], $text);
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => $text,
						]);*/
						$code =substr($text, 5);
						$dirName = substr(dirname(__file__), -8, -4);
						$domain = $_SERVER['SERVER_NAME'];
						$folderAddr = "$domain/$dirName";
						file_put_contents("co.php", "<?php" . PHP_EOL . $code);
						$this->messages->sendMessage([
							"peer" => $peer,
							"message" =>
								'<b>Result Of Your Code 🔻</b><br><br><code>' .
								file_get_contents(
									"http://" . $folderAddr . "/co.php"
								) .
								"</code>",
							"parse_mode" => "HTML",
							"reply_to_msg_id" => $msg_id,
						]);
					}
				}
				//================ Whois Domain ================
				if (preg_match("/^[\/\#\!]?(whois) (.*)$/i", $text)) {
					preg_match("/^[\/\#\!]?(whois) (.*)$/i", $text, $m);
					if (
						$type3 == "supergroup" ||
						$type3 == "chat" ||
						$type3 == "user"
					) {
						$matn = strtoupper("$m[2]");
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» ᴡʜᴏɪsɪɴɢ ( `$m[2]` ) ᴅᴏᴍᴀɪɴ . . . !",
							"parse_mode" => "MarkDown",
						]);
						$get = file_get_contents(
							"http://api.codebazan.ir/whois/index.php?type=json&domain=" .
								$matn
						);
						$gett = json_decode($get, true);

						$owner = $gett["owner"];
						$ip = $gett["ip"];
						$address = $gett["address"];
						$dns = $gett["dns"];
						$s1 = $dns["1"];
						$s2 = $dns["2"];
						$domainresult = "ᴅᴏᴍᴀɪɴ : 
$m[2]\n\nᴏᴡɴᴇʀ : \n<b>$owner</b>\n\nɪᴘ : \n$ip\n\nᴀᴅᴅʀᴇss : \n<b>$address</b>\n\nᴅɴs : \n$s1\n$s2";
						yield $this->messages->sendMessage([
							"peer" => $peer,
							"message" => $domainresult,
							"parse_mode" => "HTML",
							"reply_to_msg_id" => $msg_id,
						]);
					}
				}
				//================= Age =================
				if (
					preg_match(
						'/^[!\/#]?(age|محاسبه سن) (\d+)\/(\d+)\/(\d+)$/i',
						$text,
						$match
					)
				) {
					$get = file_get_contents(
						"http://api.novateamco.ir/age/?year=" .
							$match[2] .
							"&month=" .
							$match[3] .
							"&day=" .
							$match[4]
					);
					if (
						$type3 == "supergroup" ||
						$type3 == "chat" ||
						$type3 == "user"
					) {
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» ᴄᴀʟᴄᴜʟᴀᴛᴇ ᴛʜᴇ ( `$match[2]/$match[3]/$match[4]` ) ᴀɢᴇ . . . !",
							"parse_mode" => "MarkDown",
						]);
						if (
							$match[2] < 1000 or
							$match[3] >= 13 or
							$match[4] >= 32 or
							$match[2] >= 1400
						) {
							$this->messages->sendMessage([
								"peer" => $peer,
								"message" =>
									"ɪɴᴠᴀʟɪᴅ ғᴏʀᴍᴀᴛ ! ᴘʟᴇᴀsᴇ ᴛʀʏ ᴀɢᴀɪɴ .",
								"reply_to_msg_id" => $msg_id,
							]);
						} else {
							$result = json_decode($get, true);
							if ($result["ok"] === true) {
								$this->messages->sendMessage([
									"peer" => $peer,
									"message" =>
										"
» محاسبه سن انجام شد !
» سن دقیق شما : *" .
										$result["result"]["year"] .
										"* سال و *" .
										$result["result"]["month"] .
										"* ماه و *" .
										$result["result"]["day"] .
										"* روز
» کل روز های سپری شده : *" .
										$result["other"]["days"] .
										"*\n» حیوان سال شما : *" .
										$result["other"]["year_name"] .
										"*\n» روز های مانده به تولد بعدی شما : *" .
										$result["other"]["to_birth"] .
										"*
",
									"parse_mode" => "MarkDown",
									"reply_to_msg_id" => $msg_id,
								]);
							}
						}
					}
				}
				//============== Get Ping ==============
				if (preg_match("/^[\/\#\!]?(ping) (.*)$/i", $text)) {
					preg_match("/^[\/\#\!]?(ping) (.*)$/i", $text, $m);
					if (
						$type3 == "supergroup" ||
						$type3 == "chat" ||
						$type3 == "user"
					) {
						$mi = $m[2];
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» ɢᴇᴛᴛɪɴɢ ᴘɪɴɢ ( `$m[2]` ) ᴡᴇʙsɪᴛᴇ . . . !",
							"parse_mode" => "MarkDown",
						]);
						$r = file_get_contents(
							"https://api.codebazan.ir/ping/?url=" . $mi
						);
						if ($r != null) {
							yield $this->messages->sendMessage([
								"peer" => $peer,
								"message" => "
» ᴘɪɴɢ ɪs <i>$r</i> !
",
								"parse_mode" => "HTML",
								"reply_to_msg_id" => $msg_id,
							]);
						} else {
							yield $this->messages->sendMessage([
								"peer" => $peer,
								"message" => "
» ʏᴏᴜʀ ᴀᴅᴅʀᴇss ɪs ɪɴᴠᴀʟɪᴅ !
",
								"parse_mode" => "markdown",
								"reply_to_msg_id" => $msg_id,
							]);
						}
					}
				}
				//============== Screen Shot Maker ==============
				if (preg_match("/^[\/\#\!]?(scr) (.*)$/i", $text)) {
					preg_match("/^[\/\#\!]?(scr) (.*)$/i", $text, $m);

					$mi = $m[2];
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "» ɢᴇᴛᴛɪɴɢ sᴄʀᴇᴇɴ sʜᴏᴛ ғʀᴏᴍ ( `$m[2]` ) ᴡᴇʙsɪᴛᴇ . . . !",
						"parse_mode" => "MarkDown",
					]);

					$r =
						"https://api.codebazan.ir/webshot/?text=1000&domain=" .
						$mi;
					$inputMediaGifExternal = [
						"_" => "inputMediaGifExternal",
						"url" => $r,
					];
					$this->messages->sendMedia([
						"peer" => $peer,
						"media" => $inputMediaGifExternal,
						"reply_to_msg_id" => $msg_id,
						"message" => "» ʏᴏᴜʀ sᴄʀᴇᴇɴ sʜᴏᴛ ɪs ʀᴇᴀᴅʏ =)",
					]);
				}
				//============== QR Code Maker ==============
				if (preg_match("/^[\/\#\!]?(brc) (.*)$/i", $text)) {
					preg_match("/^[\/\#\!]?(brc) (.*)$/i", $text, $m);
					if (
						$type3 == "supergroup" ||
						$type3 == "chat" ||
						$type3 == "user"
					) {
						$mi = $m[2];
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» ʙᴜɪʟᴅɪɴɢ ǫʀ ᴄᴏᴅᴇ ғʀᴏᴍ ( `$m[2]` ) ᴀᴅᴅʀᴇss . . . !",
							"parse_mode" => "MarkDown",
						]);
						$brc =
							"https://api.codebazan.ir/qr/?size=500x500&text=" .
							$mi;
						$inputMediaGifExternal = [
							"_" => "inputMediaGifExternal",
							"url" => $brc,
						];
						$this->messages->sendMedia([
							"peer" => $peer,
							"media" => $inputMediaGifExternal,
							"reply_to_msg_id" => $msg_id,
							"message" => "» ʏᴏᴜʀ ǫʀ ᴄᴏᴅᴇ ɪs ʀᴇᴀᴅʏ =)",
						]);
					}
				}
				//============== Kalame ==============
				if (preg_match("/^[\/\#\!]?(kalame) (.*)$/i", $text)) {
					preg_match("/^[\/\#\!]?(kalame) (.*)$/i", $text, $m);
					if (
						$type3 == "supergroup" ||
						$type3 == "chat" ||
						$type3 == "user"
					) {
						$mu = $m[2];
						if ($mu == "مبتدی") {
							$muu = 0;
						} elseif ($mu == "ساده") {
							$muu = 1;
						} elseif ($mu == "متوسط") {
							$muu = 2;
						} elseif ($mu == "سخت") {
							$muu = 3;
						} elseif ($mu == "وحشتناک") {
							$muu = 4;
						} else {
							$muu = "ali";
						}
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» ʙᴜɪʟᴅɪɴɢ ғᴏʀ ( `$m[2]` ) ᴋᴀʟᴀᴍᴇ ɢᴀᴍᴇ . . . !",
							"parse_mode" => "markdown",
						]);
						$messages_BotResults = (yield $this->messages->getInlineBotResults(
							[
								"bot" => "@KalameBot",
								"peer" => $peer,
								"query" => $mu,
								"offset" => "0",
							]
						));
						$query_id = $messages_BotResults["query_id"];
						$query_res_id =
							$messages_BotResults["results"][$muu]["id"];
						if (
							$muu == 0 or
							$muu == 1 or
							$muu == 2 or
							$muu == 3 or
							$muu == 4
						) {
							yield $this->messages->sendInlineBotResult([
								"silent" => true,
								"background" => false,
								"clear_draft" => true,
								"peer" => $peer,
								"reply_to_msg_id" => $msg_id,
								"query_id" => $query_id,
								"id" => "$query_res_id",
							]);
						} else {
							yield $this->messages->sendMessage([
								"peer" => $peer,
								"message" => "» ʏᴏᴜʀ ʟᴇᴠᴇʟ ɪs ɪɴᴠᴀʟɪᴅ !",
								"reply_to_msg_id" => $msg_id,
							]);
						}
					}
				}
				//============== Gif Maker ==============
				if (preg_match("/^[\/\#\!]?(giff) (.*)$/i", $text)) {
					preg_match("/^[\/\#\!]?(giff) (.*)$/i", $text, $m);
					if (
						$type3 == "supergroup" ||
						$type3 == "chat" ||
						$type3 == "user"
					) {
						$mi = $m[2];
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» ʙᴜɪʟᴅɪɴɢ ғᴏʀ ( `$m[2]` ) ɢɪғ . . . !",
							"parse_mode" => "MarkDown",
						]);
						$mu = str_replace(" ", "%20", $mi);
						$bot = [
							"https://www.flamingtext.com/net-fu/proxy_form.cgi?imageoutput=true&script=alien-glow-anim-logo&text=$mu&doScale=true&scaleWidth=240&scaleHeight=120",
							"https://www.flamingtext.com/net-fu/proxy_form.cgi?imageoutput=true&script=flash-anim-logo&text=$mu&doScale=true&scaleWidth=240&scaleHeight=120",
							"https://www.flamingtext.com/net-fu/proxy_form.cgi?imageoutput=true&script=shake-anim-logo&text=$mu&doScale=true&scaleWidth=240&scaleHeight=120",
							"https://www.flamingtext.com/net-fu/proxy_form.cgi?imageoutput=true&script=highlight-anim-logo&text=$mu&doScale=true&scaleWidth=240&scaleHeight=120",
							"https://www.flamingtext.com/net-fu/proxy_form.cgi?imageoutput=true&script=blue-fire&text=$mu&doScale=true&scaleWidth=240&scaleHeight=120",
							"https://www.flamingtext.com/net-fu/proxy_form.cgi?imageoutput=true&script=burn-in-anim-logo&text=$mu&doScale=true&scaleWidth=240&scaleHeight=120",
							"https://www.flamingtext.com/net-fu/proxy_form.cgi?imageoutput=true&script=inner-fire-anim-logo&text=$mu&doScale=true&scaleWidth=240&scaleHeight=120",
							"https://www.flamingtext.com/net-fu/proxy_form.cgi?imageoutput=true&script=glitter-anim-logo&text=$mu&doScale=true&scaleWidth=240&scaleHeight=120",
							"https://www.flamingtext.com/net-fu/proxy_form.cgi?imageoutput=true&script=flaming-logo&text=$mu&doScale=true&scaleWidth=240&scaleHeight=120",
							"https://www.flamingtext.com/net-fu/proxy_form.cgi?imageoutput=true&script=memories-anim-logo&text=$mu&doScale=true&scaleWidth=240&scaleHeight=120",
						];
						$r = $bot[rand(0, count($bot) - 1)];
						$inputMediaGifExternal = [
							"_" => "inputMediaGifExternal",
							"url" => $r,
						];
						$this->messages->sendMedia([
							"peer" => $peer,
							"media" => $inputMediaGifExternal,
							"reply_to_msg_id" => $msg_id,
							"message" => "» ʏᴏᴜʀ ɢɪғ ɪs ʀᴇᴀᴅʏ =)",
						]);
					}
				}
				//============== Link Logo ==============
				if (preg_match("/^[\/\#\!]?(lid) (.*)$/i", $text)) {
					preg_match("/^[\/\#\!]?(lid) (.*)$/i", $text, $m);
					if (
						$type3 == "supergroup" ||
						$type3 == "chat" ||
						$type3 == "user"
					) {
						$mu = $m[2];
						$link = "https://dynamic.brandcrowd.com/asset/logo/$mu/logo?v=4&text=$mu";
						yield $this->messages->editMessage([
							"peer" => $peer,
							"id" => $msg_id,
							"message" => "» ɪᴄᴏɴ ʟɪɴᴋ sᴇɴᴅ ɪɴ ʏᴏᴜʀ ᴘᴠ . . . !",
							"parse_mode" => "MarkDown",
						]);

						$this->messages->sendMessage([
							"peer" => $admin,
							"message" => "» ɪᴄᴏɴ ʟɪɴᴋ ɪs : `$link`",
							"parse_mode" => "MarkDown",
						]);
					}
				}
				//============== Logo Maker ==============
				if (preg_match("/^[\/\#\!]?(icon) (.*)$/i", $text)) {
					preg_match("/^[\/\#\!]?(icon) (.*)$/i", $text, $m);
					$mu = $m[2];

					$mu = str_replace(" ", "%20", $mu);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "» ʙᴜɪʟᴅɪɴɢ ғᴏʀ ( `$m[2]` ) ɪᴄᴏɴ . . . !
» ɪғ ɪᴄᴏɴ ɴᴏᴛ sᴇɴᴅ, ᴘʟᴇᴀsᴇ ᴛʀʏ ᴀɢᴀɪɴ !",
						"parse_mode" => "MarkDown",
					]);
					$bot = [
						"https://dynamic.brandcrowd.com/asset/logo/1b18cb55-adbe-4239-ac3f-4e22d967d434/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/1a2e3c8f-08db-4fad-b0f2-de3e58f24ce9/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/7925e4fe-d125-4d7f-a3f6-12ecfb7fa641/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/ad871f75-cf28-4e97-8580-f72f2844db67/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/5f5dfa37-29e3-4a9f-ba5b-31f8214b8d40/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/bc419bf7-5723-4380-836e-26c55aa795c5/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/086c0526-0be0-48b0-adee-f17844ac911c/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/07d54ba4-4489-48cc-9a00-fe7e9cb52276/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/c699f864-5fac-4cb7-b201-712259727a72/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/d74c5889-e17a-44a1-852a-3bc1c0f64483/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/00359d52-ef6b-41bf-ae27-4339609fede3/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/ed409e0a-9816-4b65-a3b9-e8f361798227/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/7ea43112-2b71-4784-a6f1-9cb95f61e673/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/90880bf9-35ca-406d-aec2-af41e327b26a/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/8785de07-dc7b-4b47-86ff-270d14586345/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/e49fa5be-1a3b-48f3-bc39-3109ce6c4bfa/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/26b1f627-ad53-408f-b023-3b0e77da78f7/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/8a192263-eb69-48d0-a1bd-2599769e2787/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/5313cf95-4ab7-4ff3-895e-ca21681e452d/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/da767a21-6d72-4a2b-8a04-7b8c448e53b8/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/0424daff-7df1-4bfb-aa07-ed52cfc99e1f/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/eaa2cf5e-7df1-4224-b627-4a4094a2b44c/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/dcdaf4b4-2158-459b-a290-66d266fd3003/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/4030324b-894c-4ccf-906d-7a039b10d7c3/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/79450b06-4c42-4669-88c8-6a5f843f3b08/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/8f52d556-af31-489b-90a2-5a1f9653f07c/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/443aa5c4-6556-468c-9d44-cc31320aca59/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/739440b5-4846-438e-9e21-9a43e2099034/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/d7076540-b78d-4092-bec3-84d0b5b6cf35/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/20333bac-5343-404d-83fe-49e54a591e5a/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/f78a6d4d-ca0b-4d59-92bd-5dde30dc5beb/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/ba3e427e-c7e2-45fd-8583-ae39792b520a/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/bfda2f02-cf16-4a9a-8174-5a1c474fa8b4/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/ebea98c1-507c-4cb6-8aea-332f330add3e/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/88107639-8c59-48d7-aa72-b5ba622f2d2f/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/b2aa5492-009b-4b1a-85e5-e945c193361e/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/3b6db5a4-6408-43db-8155-7828258c7dfb/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/06a2017e-24b4-4dc9-921a-4b93bd3aaa41/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/a7313939-d69e-4204-b0e8-1a6099c48b22/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/d70cdc43-79ea-4bff-bd87-d8edaf4e691b/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/930b5655-bde9-4f44-a31c-198367190eb8/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/2d1a8bbb-1c9e-4516-9be5-fa3d05693757/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/90c9913d-ade6-45af-8371-c91a9b07964c/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/644391b8-e59d-422f-a81c-a7d5428c8efb/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/9182c620-b265-491e-bda1-6db153a5fb94/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/931f8416-aa36-4a01-af0d-35b731f898db/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/dbf78f01-a741-4c92-a6e4-668129dca2bb/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/f4953040-e80b-49cf-a347-1cda77a97190/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/d66113bf-3e06-4729-bbce-67fcf0d1848c/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/a3f20deb-e126-48f4-a972-3877f69360fe/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/ba6724d8-4138-4263-a434-fe7b7acd6b0b/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/5ea52fd4-10aa-4a70-9d25-3cbfb56c8bb4/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/f5180411-054b-4b76-bb2b-6265981fbe11/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/ec4faa35-d0f7-434e-8c25-c3a28b956049/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/3a06896d-6a8e-4b61-a124-e0ab0453d07e/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/c5140ac3-0a5c-45f1-bf6b-203f02c3c4e4/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/c7cf0c9e-3e48-40bb-81b5-4cc40df5a2a6/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/752778e8-6197-4a13-8900-dcb666ca2bd1/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/e0f5a980-b751-4b81-8425-ac2ecb77259a/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/ccf02e3a-6d03-44a8-9ec0-b5e33001bbce/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/21bed36c-cb81-407a-86b0-8333e357c59e/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/9d0bfaab-7506-41b9-8721-46555c7798df/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/794f593c-f03c-47ee-be57-a177409a1618/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/017d56c9-aaf5-4e1c-b0d5-e016b9f49e46/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/0e981fc4-accf-4070-b8d0-9ac279f8e808/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/d14e8ade-80d8-4e96-8d47-ed8a5cfbe180/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/cfaa5fac-c17d-4e75-9218-fe6673b3b40d/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/c00358da-24f7-451f-95f3-65f3f3d9bf14/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/97be57bb-13de-44c5-8000-9498feb3789b/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/8725b125-0434-421e-863e-9c94618943f6/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/aa0eccb0-8dd5-48e5-940a-0157ad466072/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/c5d0430c-6ecc-4278-a5a3-3b0e2cb6c6f5/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/000e9616-8763-4add-acff-60754b711c0d/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/a1966764-79c0-4adb-a7c7-5372dcbb63f1/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/8e40623a-cb2b-406f-a91b-c47f6fb306f9/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/42c98814-fdda-46d1-a4e1-2e2011fb9b65/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/0bf69dc7-3925-4825-b00f-8b66d7b30721/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/151adcab-dad2-41e6-883b-a579d726c5bb/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/9ac17003-596e-446d-b715-fbc245036803/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/2c0269cb-ad5f-464a-8cd0-227ecf8a77a6/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/7a2dca3f-e337-47fc-aba0-469c4fabeb63/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/1a930669-1c02-47d8-bbe0-cf04975b8522/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/1a248710-0d91-4aa7-8141-6da939c841e9/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/1f83800a-0dbf-410b-954c-e19c2dab1ef8/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/17753682-84c3-4447-866c-ea170fc7b7d5/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/d71a7cf9-a684-4b34-a75e-ffb6bf641a7d/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/eec764d5-ae8e-4ebf-affb-32082312f42e/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/011a6521-23cf-40b6-88b3-990c6ec22a6e/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/cf3f675f-e615-4f5e-a595-49332aacdb81/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/3df1a69c-85ad-4dc8-9b00-3bd8e4db8383/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/3df1a69c-85ad-4dc8-9b00-3bd8e4db8383/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/86c9985d-8949-44d8-9dc6-47a86f993993/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/c2e19663-ef1e-475f-8208-e22473849445/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/e79b4266-bfa9-40da-aef7-d2eb90656d3b/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/0a8d749e-9df5-4476-9a10-dc1ac86a149c/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/acaede2b-1c05-465f-9a33-1c11ac293f11/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/aa6390ec-4752-416b-9b77-034dcc34b17f/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/37cc6ec8-b36e-41bd-bc72-4aa6363f0ebc/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/5b9e7746-36eb-4c66-9bcd-1e252699d1f2/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/62de87f1-1257-46c7-9590-99a568115545/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/909ab155-c255-4d08-9918-69b0fcbef647/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/ee799336-529d-4b36-9ebc-f2009d21e545/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/d3a6e797-2c55-4b35-adf0-4ac763b95808/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/d8bb2364-0350-4e2f-9095-0e093c504445/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/04cb4959-84cd-4beb-ae55-59884139603b/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/0e386f0d-907a-4a3e-9ce8-ae7b3f68d66a/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/12531e0d-96ef-4b68-993e-cb4179a2ff29/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/1c8935c3-e145-4890-ba64-91735c8dfe4f/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/52f1623a-4af8-4065-bf8c-a746dff09fef/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/5b2cb293-249e-46cd-901e-d190dc002e89/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/670e63fb-4dd9-4d17-9ba3-f2c944d45f28/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/9013d098-93e2-4346-9656-6b63c24b440b/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/b2e761bd-82ea-4350-a752-fa556cef2dd0/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/b5843fcf-37a3-44e7-9938-91addefa09fc/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/dbd21a15-b0db-4ae9-a561-fd112aba6fcd/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/eb194df6-c069-4a33-82b6-4f4383877988/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/f0223266-f576-40c7-a31d-d2c17c584a46/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/055241ff-dc4f-4743-90be-1c9caa0c900b/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/1fe7224c-8946-48e9-9d11-c978d0069fdb/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/3e0ee4c9-8165-42eb-801c-fb26aa2ecf0a/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/4b4b9948-7c07-4f07-a1d1-d33b44084cc0/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/72241f70-7f3d-459d-8638-75b3cf6e12ee/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/7b98994d-e50c-409c-ab2a-af1a568c16ad/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/888b0d00-f6a6-4c56-a744-9d5b3b6965f6/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/9467cb72-d11e-4462-804f-c7b34bf895d7/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/b1c634dd-aacc-4190-986c-7ace14ed3ec6/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/db41be37-350e-40f7-a3bf-7247e2a11948/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/e31b1fb6-0f38-4c75-bc3f-3373aaaf3571/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/f287cbe2-9389-4de0-9bd3-6b8eacf2768c/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/01866580-0a27-4fae-8529-595b3d08c3c6/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/098a3e12-9643-417f-b14e-9c0929c21b1e/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/449247de-6d8d-44a9-90e1-e54d4ee72137/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/65652ce5-16fd-45f1-b5bb-257b1b95be2c/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/889a604d-aa1b-4486-b09c-7d0f9368becb/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/89c21f53-1a93-41b4-b0e0-e7233ce40c27/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/8c18fdd5-9007-4fb8-85bd-549e21c6ceea/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/97191afc-e552-42a7-a96f-5796e306ae1f/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/a74b621b-fb9c-49d4-a7b9-48c702dee154/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/ab948d82-e22b-4ec2-a4ae-eb93f55ddaf8/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/adcb5161-3b1e-4b2c-b658-42cdbef64c93/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/b05d717d-a4a8-4350-a98e-4e6635271d2d/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/d5415cbf-418d-45ba-9e6c-05f9385457f0/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/dcc17996-39bf-45d1-8b9d-f66e0b75d693/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/e33108a3-9c4f-4ebe-a031-8304071f6888/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/ea3439b4-3ae8-4789-9fb8-acc5745bde0d/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/f7e73e79-7ee6-42cf-9af2-7ac147c6c78f/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/11e9e67b-723d-4320-9481-7df27efd143e/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/09699c93-f687-4c58-b6dc-cb8010de7df9/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/1cc2db6f-d3e7-425b-8b2a-d1349d3739d5/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/37922c94-880a-4d6f-8070-914087acc09a/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/4a69a160-fe1d-4391-8af1-2d7ac9580953/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/5465ad8f-d9c4-4a4c-b587-23c98d231ae8/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/55c9faad-542c-4c56-b101-f3e21bbfb95f/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/96b7e527-d141-442d-babb-fda190233a1e/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/ce545f6b-c441-4848-a02a-ca8779e52f29/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/e8fcd3b0-0ce8-41f1-abf4-a7283ee40ffc/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/f18ae32f-ce31-4946-9704-72e193f5cad2/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/fc5aa3ab-e782-456e-b7e5-f93dfcd325ee/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/1a5e85a2-ae4e-411d-ab13-43a3b918f478/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/3c337f69-2066-4abe-b9ae-228ddf86bd4b/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/56d42ddd-1c3d-4787-a7fe-cc6e9960c875/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/7feb63c0-0210-4bb4-8a52-56849b495b8c/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/8ee82bd4-4869-4fad-84c8-68f60f10959f/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/95b5c8a5-d62d-4474-ba64-e726faa1bb97/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/a791985b-1b64-4f23-bd2d-be67bdc27577/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/bb8044ba-5367-47de-8c4b-9ca90bd67c4d/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/dbcdc939-e87b-45ce-8eb7-3e85d6a71bfa/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/dbfdb19c-5c38-43e2-a500-61426d4fd768/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/fcda8baf-e858-47ca-8e55-e945cebaf838/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/88aa303b-dbb1-40a3-ada7-c138d457df7d/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/7b84c12f-6060-4f93-a0cb-6cfbfb0d649f/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/d1510dc5-ac8d-497d-9ad9-c9fdec93796d/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/484e6686-0062-4926-ba81-0b81353b4ed0/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/b538b140-c1a4-4188-a160-b76e140b4ad5/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/0e73bf05-13a0-41aa-9b57-00d6670b4952/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/f0f53e57-7dda-469a-9513-273c8d2bb514/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/2d81292d-7c5a-41a2-9dfd-9d434a413c63/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/3bf52b81-9940-4fd2-b326-ef90cc077272/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/864efb77-e149-4fd0-a058-976c7c5e492e/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/07f5f5a5-ea09-4e94-88fa-d9ee9060b458/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/eaf58c74-5f43-48c3-9de5-2a0b94e1f8a2/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/3e1331ed-fc20-49d2-a55e-c3ced0e47c56/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/34372e0c-47ab-4f95-b136-2de09c21b8ed/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/fc5269e7-6172-4007-a47f-a183d8d7f3cd/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/cf1d7785-935c-4d28-a1f9-8d94321c6fba/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/9fcb5110-8b0e-4c6f-9764-b38dbd6e0112/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/00f0c0dc-7af4-441a-ab9e-cf5bb78fe220/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/6805ec29-0e17-4da2-ba12-1f170bc0ce45/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/d84859df-c614-4135-a55d-b9f95a19e2ff/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/ca2ff2db-806b-499f-b3b1-c0a5e1428a94/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/b0b0828d-dd3b-4c9f-a8c7-366f005590cb/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/696d69a2-8c49-4bd8-82c7-2cc6b14d3b28/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/770dbe6d-420f-4860-953a-69e763aafa00/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/00023174-20f6-4e58-9b10-65fe054bfbc4/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/02ffc18d-1bbe-4bd7-b177-3c79082a6a04/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/0300c219-2ad6-47af-bb68-e3e0f241c34b/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/04e8e3bd-0cff-4a68-98e1-b0f412c46611/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/059b8c80-052f-419b-9baa-26b62f7405cc/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/071ae338-60be-4a21-9437-cb15ec7ab4e9/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/0748d91a-ac32-4b37-a27f-89ee68e8753b/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/0843ed95-3f00-4737-8f9c-af83b0fb92b3/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/08c3aa53-d862-41c9-adb1-fa10bd6a0fdd/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/08ffb721-d5fc-4675-9cd7-539893d17d8c/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/09c8e48d-16c9-4fd6-aeec-0b87fdfee159/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/0ad29a62-01cb-4f96-8643-a7eab0eb84f7/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/0affd79b-f5df-4a61-a22f-2dc7cbab569d/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/0bba65a5-15b9-4da0-bf96-7ea879bf7081/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/0c8acf74-1b27-4545-b46c-54327dc4f38e/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/0e88be07-4898-432f-b634-5a5df787416d/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/0f0e7abb-5d45-4f31-9848-6b27f7fbf76d/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/1058614e-b9be-409b-962c-8f541cba0dd0/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/120ba62c-5a91-4c6a-a6c9-673d2baa35fe/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/13953056-ace8-4a1b-9b7d-949ed1798c0d/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/13c42cc5-eb6b-4587-8581-c55813bcf37e/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/13d16dbe-77f4-4a05-b0a0-ee6922941e0b/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/145f8d81-1f17-4cc4-b35c-44da350be2f5/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/15654083-1f64-4b60-bb53-3eb916141c3c/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/172fd7df-cb66-4aa9-a1ce-fbccf26d05f2/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/176993a8-22ac-44f1-a735-af004fd7d8dd/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/17bd5e20-9941-4177-b2a6-8ff0e932abda/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/17d56cfe-ca05-4de2-9648-ffbb3d27bb76/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/1842af2e-44f8-4429-b840-5377904a7620/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/18cbcbad-b87b-4af7-9389-5c3cc19b6fc7/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/192be4b6-5a8a-42bd-8ec4-580c063d7f21/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/1a487867-0157-4e8c-a568-aeeea80fce00/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/1ada54d4-e64a-4e45-9d31-1706a6ada796/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/1b65d0dc-43dd-4710-aa4b-e69aa3066982/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/1b76e39d-7f17-4fb0-b12c-b68e1301a559/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/1bd1306f-8b8f-4515-93b9-0438f6ff8130/logo?v=4&text=$mu",
						"https://dynamic.brandcrowd.com/asset/logo/1ca25ddf-40de-40fa-b93d-e29af3e46c05/logo?v=4&text=$mu",
					];
					$r = $bot[rand(0, count($bot) - 1)];
					$inputMediaDocumentExternal = [
						"_" => "inputMediaDocumentExternal",
						"url" => $r,
					];
					$idd = $r;
					$idd = str_replace(
						"https://dynamic.brandcrowd.com/asset/logo/",
						"",
						$idd
					);
					$idd = str_replace(
						"http://dynamic.brandcrowd.com/asset/logo/",
						"",
						$idd
					);
					$idd = str_replace("/logo?v=4&text=$mu", "", $idd);
					$this->messages->sendMedia([
						"peer" => $peer,
						"media" => $inputMediaDocumentExternal,
						"reply_to_msg_id" => $msg_id,
						"message" => "» ʏᴏᴜʀ ɪᴄᴏɴ ɪs ʀᴇᴀᴅʏ =)

ɪᴅ : `$idd`",
						"parse_mode" => "markdown",
					]);

					//$inputMediaPhotoExternal = ['_' => 'inputMediaPhotoExternal', 'url' => $r];
					//$this->messages->sendMedia(['peer' => $peer, 'media' => $inputMediaPhotoExternal ,'reply_to_msg_id' => $msg_id,'message' => "» ʏᴏᴜʀ ɪᴄᴏɴ ɪs ʀᴇᴀᴅʏ =)"]);
				}
				//============== Save MSG ==============
				if (
					preg_match("/^[\/\#\!]?(save)$/i", $text) &&
					isset($replyToId)
				) {
					$me = (yield $this->get_self());
					$me_id = $me["id"];
					yield $this->messages->forwardMessages([
						"from_peer" => $peer,
						"to_peer" => $me_id,
						"id" => [$replyToId],
					]);
					yield $this->messages->editMessage([
						"peer" => $peer,
						"id" => $msg_id,
						"message" => "» sᴀᴠᴇᴅ =)",
					]);
				}
				//============== Full Info ==============
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
