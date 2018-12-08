<?php

namespace App\Helper;

class Parser
{

    private $messages;
    private $file_location;
    private $message_only;
    private $username_only;
    

    public function __construct($file_location) {
       $this->file_location = $file_location;
    }
    
    /**
     * Group messages into message, sender and datetime
     * @param string $file_location of backup file
     * @return array grouped messages
     */
    public function parseMessage() {
        if (!file_exists($this->file_location)) {
          throw new \Exception("File not found");
        }
        
        $lines = file($this->file_location);

        $messages = [];

        try{
            foreach ($lines as $line) {
                preg_match('/(?<datetime>\d*\/\d*\/\d*,\s*\d*:\d*\s*(?:PM|AM))\s*\s*-\s*(?<username>[^:]*)(?<message>.*)/', $line, $matches);

                if (($matches)) {
                    if (empty($matches['message']) AND $matches['username']) {
                        $messages[] = [
                            "username" => "from_whatsapp",
                            "message" => $matches['username'],
                            "time" => $matches['datetime']
                        ];
                    } else {
                        $messages[] = [
                            "username" => $matches['username'],
                            "message" =>  substr($matches['message'], 2),
                            "time" => $matches['datetime']
                        ];
                    }
                } else {
                    // if there is no match
                    // Append the text to the last, bcos it's probably
                    // a continuation of prev. mesg. in new line
                    // If there is no last message, discard the text and cont.
                    $message_count = count($messages);
                    
                    if ($message_count) {
                        $last_message = $messages[$message_count - 1];
                        $messages[$message_count-1]['message'] .= $line;
                    }
                }
            }
        } catch( \Exception $e) {
           //   var_dump($e);
        }

        $this->messages = $messages;
        $this->message_only = array_column($messages, 'message');
        $this->username_only = array_values(
            array_unique(array_column($messages, 'username'))
        );

        return $this;
    }

    public function messageOnly() {
      return $this->message_only;
    }

    public function usernameOnly() {
      return $this->username_only;
    }

    public function toArray() {
        return $this->messages;
    }

    public function toJson() {
        return json_encode($this->messages);
    }

    public function getCsv() {
        $out = fopen('php://output', 'w');
        fputcsv($out, $this->messages);
        fclose($out);
    }
}