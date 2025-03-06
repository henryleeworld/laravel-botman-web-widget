<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use Illuminate\Foundation\Inspiring;

class WakeUpConversation extends Conversation
{
    /**
     * First question
     */
    public function askReason()
    {
        $question = Question::create(__('Ah, you woke me up, what do you need?'))
            ->fallback(__('Unable to ask questions'))
            ->callbackId('ask_reason')
            ->addButtons([
                Button::create(__('Tell a joke'))->value('joke'),
                Button::create(__('Give me an inspirational quote'))->value('quote'),
            ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'joke') {
                    $joke = json_decode(file_get_contents('http://api.icndb.com/jokes/random'));
                    $this->say($joke->value->joke);
                } else {
                    $this->say(Inspiring::quote());
                }
            }
        });
    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->askReason();
    }
}
