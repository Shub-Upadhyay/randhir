<?php
// Assuming the controller file is named AlwaysTrueController.php
// Place this file in your CakePHP controllers directory

namespace App\Controller;

use Cake\Controller\Controller;

class AlwaysTrueController extends Controller
{
    public function index()
    {
        $this->autoRender = false; // Disable view rendering
        $permission = false;
        // Set the response as JSON with 'success' property set to true
        $this->response = $this->response->withType('application/json')
                                         ->withStringBody(json_encode(['success' => $permission]));
        
        return $this->response;
    }
}

?>