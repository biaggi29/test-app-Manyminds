<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function mensagem($tipo, $mensagem) {
    $CI =& get_instance();
    $CI->session->set_flashdata('mensagem', array('tipo' => $tipo, 'mensagem' => $mensagem));
}
