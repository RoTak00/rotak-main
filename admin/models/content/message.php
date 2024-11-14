<?php

class ContentMessageModel extends BaseModel
{


    public function getMessages()
    {
        $sql = "SELECT * FROM contact_messages ORDER BY date_added DESC";
        $result = $this->db->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function setMessagesViewed()
    {
        $sql = "UPDATE contact_messages SET viewed_at = NOW() WHERE viewed_at IS NULL";
        $this->db->query($sql);
    }
}