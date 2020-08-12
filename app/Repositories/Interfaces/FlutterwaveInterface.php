<?php 
namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface FlutterwaveInterface
{
    public function transfer(Request $data);
    public function Transactions();
    public function search($name);
}