<?php

//V 2 
//Creator : CLONER_MAX
// Channel : @CLONER_MAX
ob_start();

define('API_KEY','توکن'); // Token Bot

$admin = "ایدی عددی خودتون"; 
//ربات حتما در کانال ادمین باشد
$chanell = "ایدی عددی کانالتون";
//ایدی عددی کانال

//-----------------------------------------------
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
//-----------------------------------------------
$update = json_decode(file_get_contents('php://input'));
$message = $update->message; 
$chat_id = $message->chat->id;
$textmessage = $message->text;
$from_id = $message->from->id;
$type = $update->message->chat->type;
$message_id = $message->message_id;
mkdir("data");
$gp = file_get_contents("data/gp.txt");
$user = file_get_contents("data/user.txt");
$spgp = file_get_contents("data/spgp.txt");
$stats = file_get_contents("data/stats.txt");
$tabligh = file_get_contents("data/tabligh.txt");
$tabligh1 = file_get_contents("data/tabligh1.txt");
//-----------------------------------------------
function SendMessage($chat_id,$textmessage,$message_id) {
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>$textmessage,
        'reply_to_message_id'=>$message_id,
        'parse_mode'=>"MarkDown"
    ]);
}
function ForwardMessage($chatid,$from_chat,$message_id){
	bot('ForwardMessage',[
	'chat_id'=>$chatid,
	'from_chat_id'=>$from_chat,
	'message_id'=>$message_id
	]);
	}
function save($filename, $data) {
    $file = fopen($filename, 'w');
    fwrite($file, $data);
    fclose($file);
}
//-----------------------------------------------
    $users = explode("\n",$user);
    if (!in_array($from_id,$users)){
        $myfile = fopen("data/user.txt", "a") or die("Unable to open file!");
        fwrite($myfile, "$from_id\n");
        fclose($myfile);
    }
//-----------------------------------------------
if($from_id != $chat_id) {
    if($type == "group") {
    $agp = explode("\n",$gp);
    if (!in_array($chat_id,$agp)){
    $myfile0 = fopen("data/gp.txt", "a") or die("Unable to open file!");
    fwrite($myfile0, "$chat_id\n");
    fclose($myfile0);
    }
    } elseif($type == "supergroup") {
    $aspgp = explode("\n",$spgp);
    if (!in_array($chat_id,$aspgp)){
    $myfile1 = fopen("data/spgp.txt", "a") or die("Unable to open file!");
    fwrite($myfile1, "$chat_id\n");
    fclose($myfile1);
    }
    }
    if($tabligh1 != null and $tabligh == null){
ForwardMessage($chat_id,$chanell,"$tabligh1");
    }
    if($tabligh != null and $tabligh1 == null){
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>$tabligh,
        'reply_to_message_id'=>$message_id,
        'parse_mode'=>"MarkDown"
    ]);
  }
}

if(preg_match('/^\/([Ss][Tt][Aa][Rr][Tt])/',$textmessage) and $type == "private"){

    if($tabligh != null) {
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>$tabligh,
        'reply_to_message_id'=>$message_id,
        'parse_mode'=>"MarkDown"
    ]);
  } else {
    bot('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"سلام من و به2 تاگروه اضافه کن تا شماره  خودمو بدم بهت",
        'reply_to_message_id'=>$message_id,
        'parse_mode'=>"MarkDown"
    ]);
  }
} elseif(preg_match('/^\/([Pp][Aa][Nn][Ee][Ll])/',$textmessage) and $type == "private" and $from_id == $admin){
    bot('sendMessage',[
        'chat_id'=>$admin,
        'text'=>"باسلام. به پنل ادمین خوش امدید چه کاری انجام دهم؟؟",
'reply_to_message_id'=>$message_id,
'disable_web_page_preview'=>true,
 'parse_mode'=>"MarkDown",
  'reply_markup'=>json_encode([
           'keyboard'=>[
 [['text'=>"افزودن تبلیغ"],['text'=>"تبلیغ چندگانه"]],
 [['text'=>"آمار گیری"],['text'=>"پیام همگانی"]]
 ],
  "resize_keyboard"=>true,
  ])
  ]);
} elseif($textmessage == "افزودن تبلیغ" and $type == "private" and $from_id == $admin) {
    file_put_contents("data/stats.txt","adtab");
    bot('sendMessage',[
        'chat_id'=>$admin,
        'text'=>"تبلیغ مورد نظر را ارسال کنید.",
        'reply_to_message_id'=>$message_id,
        'parse_mode'=>"MarkDown"
    ]);
} elseif($stats == "adtab") {
    file_put_contents("data/tabligh.txt","$textmessage");
    file_put_contents("data/tabligh1.txt","");
    file_put_contents("data/stats.txt","nono");
    bot('sendMessage',[
        'chat_id'=>$admin,
        'text'=>"تبلیغ شما ذخیره شد.",
        'reply_to_message_id'=>$message_id,
        'parse_mode'=>"MarkDown"
    ]);
} elseif($textmessage == "تبلیغ چندگانه" and $type == "private" and $from_id == $admin) {
    file_put_contents("data/stats.txt","adtab1");
    bot('sendMessage',[
        'chat_id'=>$admin,
        'text'=>"لطفا توجه کنید🚫
لطفا یک کانال عمومی ساخته و ربات را در آن ادمین کنید، سپس لینک پست را کپی و عدد اخر آن را به ربات ارسال کنید مثال:  https://t..me/CLONER_MAX/3
عدد ما در اینجا 3 است. عدد را ارسال کنید تا ثبت شود. تبلیغ میتواند(متن،فایل،عکس،فیلم،و هرچیزدیگری باشد).
متوجه نشدید؟؟ 

",
        'reply_to_message_id'=>$message_id,
        'parse_mode'=>"html"
    ]);
} elseif($stats == "adtab1") {
    file_put_contents("data/tabligh1.txt","$textmessage");
    file_put_contents("data/tabligh.txt","");
    file_put_contents("data/stats.txt","nono");
    bot('sendMessage',[
        'chat_id'=>$admin,
        'text'=>"پست مورد نظر شما ذخیره شد.",
        'reply_to_message_id'=>$message_id,
        'parse_mode'=>"MarkDown"
    ]);
} elseif($textmessage == "آمار گیری" and $type == "private" and $from_id == $admin) {

    $users = explode("\n",$user);
    $amar = count($users) -1;
    $gps = explode("\n",$gp);
    $agps = count($gps) -1;
    $aspgp = explode("\n",$spgp);
    $aspgps = count($aspgp) -1;
   bot('sendMessage',[
        'chat_id'=>$admin,
        'text'=>"🆕 آمار جدید ربات درحال حاظر برابراست با: 

گروه ها : 🔎 $agps

سوپرگروه ها : 🔎 $aspgps

پی وی ها : 🔎 $amar

کانال ها : { این بخش بزودی}",
        'reply_to_message_id'=>$message_id,
        'parse_mode'=>"MarkDown"
    ]);
} elseif($textmessage == "پیام همگانی" and $type == "private" and $from_id == $admin) {
    file_put_contents("data/stats.txt","pmall");
    bot('sendMessage',[
        'chat_id'=>$admin,
        'text'=>"♻️بسیار خوب، پیام خودرا ارسال کنید تا به همه ارسال کنم:",
        'reply_to_message_id'=>$message_id,
        'parse_mode'=>"MarkDown",
  'reply_markup'=>json_encode([
           'keyboard'=>[
 [['text'=>"/panel"]]
 ],
  "resize_keyboard"=>true,
  ])
    ]);
} elseif($stats == "pmall") {
if($textmessage != "برگشت"){
	$member = fopen( "data/user.txt", 'r');
		while( !feof( $member)) {
 			$user = fgets( $member);
			if($textmessage != null){
SendMessage($user,"🔵ارسال شد","html");
    }		
    }
    file_put_contents("data/stats.txt","nono");
    }
     elseif($textmessage == "/Panel" || "/panel" and $type == "private" and $from_id == $admin){
    
    file_put_contents("data/stats.txt","nono");
    bot('sendMessage',[
        'chat_id'=>$admin,
        'text'=>"به پنل برگشتید چه کاری انجام دهم؟",
'reply_to_message_id'=>$message_id,
'disable_web_page_preview'=>true,
 'parse_mode'=>"MarkDown",
  'reply_markup'=>json_encode([
           'keyboard'=>[
 [['text'=>"افزودن تبلیغ"],['text'=>"تبلیغ چندگانه"]],
 [['text'=>"آمار گیری"],['text'=>"پیام همگانی"]]
 ],
  "resize_keyboard"=>true,
  ])
  ]);
}

}
//-----------------------------------------------
if(file_exists("error_log"))unlink("error_log");
//V 2 
//Creator : CLONER_MAX
// Channel : @CLONER_MAX
?>
