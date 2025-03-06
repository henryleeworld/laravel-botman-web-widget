<?php

namespace App\Http\Controllers;

use App\Conversations\AskNameConversation;
use App\Conversations\WakeUpConversation;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Incoming\Answer;
use Illuminate\Http\Request;
  
class BotManController extends Controller
{
    /**
     * The value that was retrieved.
     *
     * @var mixed
     */
    public $botman;

    public function __construct()
    {
        $this->botman = app('botman');
    }

    /**
     * Place your BotMan logic here.
     */
    public function handle()
    { 
        $this->botman->hears('{message}', function($botman, $message) {
			$this->startConversation($message);
        });
  
        $this->botman->listen();
    }

    /**
     * Get specific conversation.
     *
     * @param string $message
     *
     */
    protected function startConversation($message)
    {
        $conversation = null;
        switch (strtolower($message)) {
            case 'hi':
            case 'hello':
            case __('hi'):
            case __('hello'):
                $conversation = new AskNameConversation();
                break;
            case 'wake up':
            case __('wake up'):
                $conversation = new WakeUpConversation();
                break;
        }
        !empty($conversation) ? $this->botman->startConversation($conversation) : $this->getInstruction();
    }

    /**
     * First question
     */
    public function getInstruction()
    {
        $this->botman->reply(__("Please enter \"Hello\" to test..."));
    }
}
