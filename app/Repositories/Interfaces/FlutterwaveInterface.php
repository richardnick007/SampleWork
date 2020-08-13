<?php 
namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface FlutterwaveInterface
{
    public function transfer(Request $data);
    public function transactions();
    public function search($name);
}