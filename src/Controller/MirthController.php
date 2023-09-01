<?php
namespace App\Controller;

use Cake\Controller\Controller;


class MirthController extends Controller
{
    public function index()
    {
        $filename = 'D:\revkeep\revkeep.txt'; // Replace with the actual path and filename of the file you want to read

        if (file_exists($filename)) {
            $fileContent = file_get_contents($filename);
            // Process the file content as needed
            // ...
            $this->set('fileContent', $fileContent);
            
        } else {
            $this->Flash->error('File not found.');
            // Handle the scenario when the file does not exist
            // ...
        }
        $this->render('index');
    }
}

?>