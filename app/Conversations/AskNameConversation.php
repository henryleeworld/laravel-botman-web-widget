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
        $question = Question::create(__('Hello, may I know your name?'))
            ->fallback(__('Unable to ask questions'))
            ->callbackId('ask_name');
        return $this->ask($question, function (Answer $answer) {
            $name = $answer->getText();
            $this->say(__('Nice to meet you,') . $name);
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
