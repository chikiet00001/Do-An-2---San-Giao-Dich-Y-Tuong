<?php 
    require_once __DIR__ . '/../DataAccessLayer/MessageDAL.php';

    class MessageBLL{
        private $messageDAL;

        public function __construct() {
            $this->messageDAL = new MessageDAL();
        }    

        public function MessageChat($userId) {
    
            $meschat = $this->messageDAL->MessageChat($userId);

            // if($meschat === null || empty($meschat)){
            //     return "Chưa có đoạn chat nào!";
            // }

            return $meschat;
        }

    }
?>