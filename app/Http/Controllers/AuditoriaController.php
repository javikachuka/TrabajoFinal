<?php

namespace App\Http\Controllers;

use App\Movimiento;
use App\Producto;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Audit;
use PhpParser\Node\Stmt\Return_;

class AuditoriaController extends Controller
{
    public function index()
    {

        $movs = Movimiento::withTrashed()->get();
        $users = User::withTrashed()->get();
        $productos = Producto::withTrashed()->get();
        $auditoriasProd = collect();
        $auditoriasMov = collect();
        $auditoriasUser = collect();
        foreach ($movs as $mov) {
            if (!$mov->audits->isEmpty()) {

                $auditoriasMov->add($mov->audits()->latest()->first());
            }
        }

        foreach ($users as $u) {
            if (!$u->audits->isEmpty()) {
                $auditoriasUser->add($u->audits()->latest()->first());
            }
        }

        foreach ($productos as $p) {
            if (!$p->audits->isEmpty()) {
                $auditoriasProd->add($p->audits()->latest()->first());
            }
        }




        return view('auditoria.index', compact('auditoriasMov', 'auditoriasUser' , 'auditoriasProd' , 'users'));
    }

    public function showMov($id){
        $tabla = 'MOVIMIENTOS';
        $movs = Movimiento::withTrashed()->get() ;
        foreach($movs as $movi){
            if($movi->id == $id){
                $auditoria = $movi->audits()->latest()->first();
                // dd($auditoria->getModified());
                // dd(empty($auditoria->old_values)) ;
                return view('auditoria.show' , compact('auditoria' , 'tabla')) ;
            }
        }
    }

    public function showUser($id){
        $tabla = 'EMPLEADOS';
        $users = User::withTrashed()->get() ;
        foreach($users as $u){
            if($u->id == $id){
                $auditoria = $u->audits()->latest()->first();
                // dd($auditoria->getModified());
                return view('auditoria.show' , compact('auditoria' , 'tabla')) ;
            }
        }
    }

    public function showProd($id){
        $tabla = 'PRODUCTOS';
        $productos = Producto::withTrashed()->get() ;
        foreach($productos as $p){
            if($p->id == $id){
                $auditoria = $p->audits()->latest()->first();
                // dd($auditoria->getModified());
                return view('auditoria.show' , compact('auditoria' , 'tabla')) ;
            }
        }
    }

}