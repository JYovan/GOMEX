<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class usuario_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        /* IMPRIMIR EL QUERY */
        /*
          ->get();
          print $this->db->last_query();
          return $this->db->result(); */
    }

    public function getRecords() {
        try {
            return $this->db->select("U.ID, U.Usuario, U.Estatus, U.Tipo", false)
                            ->from('usuarios AS U')
                            ->where_in('U.Estatus', 'A')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getAcceso($USUARIO, $CONTRASENA) {
        try {
            $this->db->select('U.*', false)->from('usuarios AS U')
                    ->where('U.Usuario', $USUARIO)
                    ->where('(CONCAT("$_",\'' . $CONTRASENA . '\',"_$")  = AES_DECRYPT(u.Contrasena, \'Escribe una frase\'))', NULL, FALSE)
                    ->where_in('U.Estatus', 'A');
            $query = $this->db->get();
            /*
             * FOR DEBUG ONLY
             */
            $str = $this->db->last_query();
            print $str;
            $data = $query->result();
            return $data;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar($array) {
        try {
            $this->db->insert("usuarios", $array);
            $query = $this->db->query('SELECT SCOPE_IDENTITY() AS IDL');
            $row = $query->row_array();
//            PRINT "\n ID IN MODEL: $LastIdInserted \n";
            return $row['IDL'];
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar($ID, $DATA) {
        try {
            $this->db->where('ID', $ID)
                    ->update("usuarios", $DATA);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificarContrasena($ID, $CONTRASENA) {
        try {
            $this->db->where('ID', $ID)
                    ->set('Contrasena', 'aes_encrypt(\'X\', UNHEX(SHA2(' . $CONTRASENA . ',512)))')
                    ->update("usuarios");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar($ID) {
        try {
            $this->db->set('Estatus', 'INACTIVO')
                    ->where('ID', $ID)
                    ->update("usuarios");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getUsuarioByID($ID) {
        try {
            return $this->db->select('U.*', false)
                            ->from('usuarios AS U')
                            ->where('U.ID', $ID)
                            ->where_in('U.Estatus', 'A')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getContrasena($USUARIO) {
        try {
            return $this->db->select('U.Contrasena', false)
                            ->from('usuarios AS U')
                            ->where('U.Usuario', $USUARIO)
                            ->where_in('U.Estatus', 'A')
                            ->get()->result();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
