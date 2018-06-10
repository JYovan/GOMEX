<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Sesion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->model('usuario_model');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["SESSION_KEY"])) {
            $this->load->view('vEncabezado')->view('vNavegacion')->view('vPie');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vPie');
        }
    }

    public function onIngreso() {
        try {
            $msg = 'Gomex2018';
            $key = 'super-secret-key';

            $encrypted_string = $this->encrypt->decode($msg, $key); 
            var_dump($this->input->get());
            $data = $this->usuario_model->getAcceso($this->input->get('Usuario'), $this->input->get('Contrasena'));
            var_dump($data);
            if (count($data) > 0) {
                $newdata = array(
                    'USERNAME' => $data[0]->Usuario,
                    'PASSWORD' => $data[0]->Contrasena,
                    'ID' => $data[0]->ID,
                    'SESSION_KEY' => TRUE,
                    'DATA_SESSION_KEY' => TRUE,
                    'Tipo' => $data[0]->Tipo,
                );
                $this->session->mark_as_temp('SESSION_KEY', 28800);
                $this->session->set_userdata($newdata);
            } else {
                print 'ACCESO DENEGADO';
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onCambiarContrasena() {
        try {
            $DATA = array(
                'Contrasena' => ($this->input->post('Contrasena') !== NULL) ? $this->input->post('Contrasena') : NULL
            );
            $this->usuario_model->onModificar($this->input->post('ID'), $DATA);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onSalir() {
        try {
            $array_items = array('USERNAME', 'PASSWORD', 'SESSION_KEY');
            $this->session->unset_userdata($array_items);
            header('Location: ' . base_url());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
