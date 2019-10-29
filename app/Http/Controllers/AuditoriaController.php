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
                foreach($mov->audits as $a){
                    $auditoriasMov->add($a);
                }
            }
        }

        foreach ($users as $u) {
            if (!$u->audits->isEmpty()) {
                foreach($u->audits as $a){
                    $auditoriasUser->add($a);
                }
            }
        }

        foreach ($productos as $p) {
            if (!$p->audits->isEmpty()) {
                foreach($p->audits as $a){
                    $auditoriasProd->add($a);
                }
            }
        }




        return view('auditoria.index', compact('auditoriasMov', 'auditoriasUser' , 'auditoriasProd' , 'users'));
    }

    public function showMov($idMov , $id){
        $tabla = 'MOVIMIENTOS';
        $movs = Movimiento::withTrashed()->get() ;
        foreach($movs as $movi){
            if($movi->id == $idMov){
                $auditoria = $movi->audits()->find($id);
                // dd($auditoria->getModified());
                // dd(empty($auditoria->old_values)) ;
                return view('auditoria.show' , compact('auditoria' , 'tabla')) ;
            }
        }
    }

    public function showUser($idUser , $id){
        $tabla = 'EMPLEADOS';
        $users = User::withTrashed()->get() ;
        foreach($users as $u){
            if($u->id == $idUser){
                $auditoria = $u->audits()->find($id);
                // dd($auditoria->getModified());
                return view('auditoria.show' , compact('auditoria' , 'tabla')) ;
            }
        }
    }

    public function showProd($idProd , $id){
        $tabla = 'PRODUCTOS';
        $productos = Producto::withTrashed()->get() ;
        foreach($productos as $p){
            if($p->id == $idProd){
                $auditoria = $p->audits()->find($id);
                // dd($auditoria->getModified());
                return view('auditoria.show' , compact('auditoria' , 'tabla')) ;
            }
        }
    }

}
