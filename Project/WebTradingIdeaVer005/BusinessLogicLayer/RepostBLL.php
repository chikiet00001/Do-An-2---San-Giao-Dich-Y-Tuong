<?php 
require_once __DIR__ . '/../DataAccessLayer/RepostDAL.php';

class RepostBLL{
    private $repostDAL;

    public function __construct() {
        $this->repostDAL = new RepostDAL();
    }

    public function addRepost($contenttype, $reason, $idreportinguser, $idreporteduser) {
        return $this->repostDAL->addRepost($contenttype, $reason, $idreportinguser, $idreporteduser);
    }

    public function getReposts() {
        return $this->repostDAL->getReposts();
    }

    public function markAsResolved($idRepost) {
        return $this->repostDAL->updateStatus($idRepost, 'resolved');
    }

    public function markAsIgnored($idRepost) {
        return $this->repostDAL->updateStatus($idRepost, 'ignored');
    }

    public function __destruct() {
        unset($this->repostDAL); // Dọn dẹp đối tượng
    }
}
?>