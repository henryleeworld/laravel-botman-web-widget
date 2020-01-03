<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class AskNameConversation extends Conversation
{
    /**
     * First question
     */
    public function askName()
    {
        $question = Question::create("你好，我能知道你的名字嗎？")
            ->fallback('無法問問題')
            ->callbackId('ask_name');

        return $this->ask($question, function (Answer $answer) {
            $name = $answer->getText();
            $this->say('很高興認識你，'.$name);
        });
    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->askName();
    }
}
