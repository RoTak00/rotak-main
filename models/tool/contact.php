<?php

class ToolContactModel extends BaseModel
{
    public function saveMessage()
    {
        $sql = "INSERT INTO contact_messages (name, email, message, date_added, ip, device)
        VALUES (
            '" . $this->db->escape($this->request->post['name']) . "',
            '" . $this->db->escape($this->request->post['email']) . "',
            '" . $this->db->escape($this->request->post['message']) . "',
            NOW(),
            '" . $this->db->escape($this->request->ip) . "',
            '" . $this->db->escape($this->request->device) . "')";

        $this->db->query($sql);


    }
}