<?php

$bot_token = trim(file_get_contents('BOT_TOKEN'));

$update = json_decode(file_get_contents('php://input'));

if (empty($update->message->new_chat_member)) {
    header('HTTP/2 204');
    exit;
}

if ($update->message->new_chat_member->is_bot) {
    header('HTTP/2 204');
    exit;
}

@file_get_contents('https://api.telegram.org/bot' . $bot_token . '/kickChatMember?chat_id=' . $update->message->chat->id . '&user_id=' . $update->message->new_chat_member->id);
@file_get_contents('https://api.telegram.org/bot' . $bot_token . '/deleteMessage?chat_id=' . $update->message->chat->id . '&message_id=' . $update->message->message_id);

header('HTTP/2 200');
header('Content-Type: application/json');
exit(json_encode(array(
    'method' => 'unbanChatMember',
    'chat_id' => $update->message->chat->id,
    'user_id' => $update->message->new_chat_member->id
)));
