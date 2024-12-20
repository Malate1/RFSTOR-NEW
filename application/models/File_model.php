<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *
 * @author https://roytuts.com
 */
class File_Model extends CI_Model {

    //table name
    private $file = 'files';   // files    
    
    function save_files_info($files,$controlno,$type) {
        //start db traction
        $this->db->trans_start();
        $userid = $this->session->userdata['user_id'];
        //file data
        $file_data = array();
        foreach ($files as $file) {
            $file_data[] = array(
                'file_name'         => $file['file_name'],
                'file_orig_name'    => $file['orig_name'],
                'file_path'         => $file['full_path'],
                'upload_date'       => date('Y-m-d H:i:s'),
                'request_number'    => $controlno+1,
                'request_type'      => $type
            );
        }
        
        //insert file data
        $this->db->insert_batch($this->file, $file_data);
        
        //complete the transaction
        $this->db->trans_complete();
        
        //check transaction status
        if ($this->db->trans_status() === FALSE) {
            foreach ($files as $file) {
                $file_path = $file['full_path'];
                
                //delete the file from destination
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
            
            //rollback transaction
            $this->db->trans_rollback();
            
            return FALSE;
        } else {
            //commit the transaction
            $this->db->trans_commit();
            
            return TRUE;
        }
    }

     function save_files_info_update($files,$controlno,$type) {
        //start db traction
        $this->db->trans_start();
        $userid = $this->session->userdata['user_id'];
        //file data
        $file_data = array();
        foreach ($files as $file) {
            $file_data[] = array(
                'file_name'         => $file['file_name'],
                'file_orig_name'    => $file['orig_name'],
                'file_path'         => $file['full_path'],
                'upload_date'       => date('Y-m-d H:i:s'),
                'request_number'    => $controlno,
                'request_type'      => $type
            );
        }
        
        //insert file data
        $this->db->insert_batch($this->file, $file_data);
        
        //complete the transaction
        $this->db->trans_complete();
        
        //check transaction status
        if ($this->db->trans_status() === FALSE) {
            foreach ($files as $file) {
                $file_path = $file['full_path'];
                
                //delete the file from destination
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
            
            //rollback transaction
            $this->db->trans_rollback();
            
            return FALSE;
        } else {
            //commit the transaction
            $this->db->trans_commit();
            
            return TRUE;
        }
    }

}