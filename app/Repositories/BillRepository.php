<?php

namespace App\Repositories;

use App\Models\bill;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillRepository extends BaseRepository
{
    protected $modelBase;

    public function __construct(bill $modelo)
    {
        $this->modelBase = new BaseRepository($modelo);
        parent::__construct($modelo);
    }

    public function justList()
    {
        $tipo = 2;
        $estado = 1;
        return $this->model->with('cliente.usuario')
            ->where('cod_bill_type', $tipo)
            ->where('cod_state', $estado)->get();
    }


    public function list(Request $request)
    {
        return $this->model->with(['cliente.usuario', 'empleado.usuario', 'estado'])
            ->where(function ($query) use ($request) {
                if (!empty($request->cliente)) {
                    $query->whereRelation('cliente.usuario', 'name', 'like', "%$request->cliente%");
                }
                if (!empty($request->empleado)) {
                    $query->whereRelation('empleado.usuario', 'name', 'like', "%$request->empleado%");
                }
                if (!empty($request->estado)) {
                    $query->where('cod_state', "$request->estado");
                }
                if (!empty($request->fecha)) {
                    $query->where('created_at', 'like', "%$request->fecha%");
                }
            })->orderBy('cod_bill', 'DESC')->get();
    }

    public function listByEmployee(Request $request, $idEmpleado)
    {

        return $this->model->with(['cliente.usuario', 'estado', 'tipo'])
            ->where(function ($query) use ($request) {
                if (!empty($request->cliente)) {
                    $query->where('cod_client', "$request->cliente");
                }
                if (!empty($request->tipo)) {
                    $query->where('cod_bill_type', "$request->tipo");
                }
                if (!empty($request->estado)) {
                    $query->where('cod_state', "$request->estado");
                }
                if (!empty($request->fecha)) {
                    $query->where('created_at', 'like', "%$request->fecha%");
                }
            })->where('cod_state', '<>', 5)->where('cod_employee', $idEmpleado)->get();
    }

    public function listByClient(Request $request, $idClient)
    {

        return $this->model->with(['empleado.usuario', 'estado', 'tipo'])
            ->where(function ($query) use ($request) {
                if (!empty($request->empleado)) {
                    $query->where('cod_employee', "$request->empleado");
                }
                if (!empty($request->tipo)) {
                    $query->where('cod_bill_type', "$request->tipo");
                }
                if (!empty($request->estado)) {
                    $query->where('cod_state', "$request->estado");
                }
                if (!empty($request->fecha)) {
                    $query->where('created_at', 'like', "%$request->fecha%");
                }
            })->where('cod_client', $idClient)->where('cod_state', '<>', 5)->get();
    }

    public function billsByDates(Request $request)
    {
        return $this->model->with(['cliente.usuario', 'empleado.usuario', 'estado'])
            ->where(function ($query) use ($request) {
                if (!empty($request->fechaInicial)) {
                    $query->where('created_at', '>=', "$request->fechaInicial");
                }
                if (!empty($request->fechaFinal)) {
                    $query->where('created_at', '<=', "$request->fechaFinal");
                }

            })->where('cod_state', '<>', 5)->get();
    }


    public function ventas()
    {
        //Aqui la funcion es para contar las ventas del cliente
        return $this->model->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->lastOfMonth()])->where('cod_employee', Auth::user()->empleado->cod_employee)->where('cod_state', '<>', 4)->count();
    }

    public function listByMonth()
    {
        return $this->model->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->lastOfMonth()])->where('cod_state', '<>', 4)->where('cod_state', '<>', 5)->get();
    }

    public function ganancias()
    {
        return $this->model->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->lastOfMonth()])->where('cod_state', '<>', 4)->where('cod_state', '<>', 1)->where('cod_state', '<>', 5)->sum('total_bill');
    }

    public function gananciasEfectivas()
    {
        return $this->model->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->lastOfMonth()])->where('cod_state', 3)->sum('total_bill');
    }
    public function gananciasNoEfectivas()
    {
        return $this->model->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->lastOfMonth()])->where('cod_state', 2)->sum('total_bill');
    }

    public function efectivas()
    {
        return $this->model->with(['cliente.usuario'])
        ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->lastOfMonth()])
        ->where('cod_state', 3) 
        ->orderBy('cod_bill','ASC')->get();
    }

    public function todasLasFacturas()
    {
        return $this->model->with(['cliente.usuario', 'empleado.usuario', 'estado'])->where('cod_state', '<>', 4)->where('cod_state', '<>', 5)
        ->where('cod_state', '<>', 1)->get();
    }

    public function listarFacturasTotales()
    {
        return $this->model->with(['cliente.usuario'])
        ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->lastOfMonth()])
        ->where('cod_state', '<>', 4)
        ->where('cod_state', '<>', 1) 
        ->where('cod_state', '<>', 5) 
        ->orderBy('cod_bill','ASC')->get();
    }
    public function contarEnProceso(){
        return $this->model->where('cod_state', 2)->count('cod_bill');
    }
    public function contarEnCompletado(){
        return $this->model->where('cod_state', 3)->count('cod_bill');
    }
    public function contarEnCancelado(){
        return $this->model->where('cod_state', 4)->count('cod_bill');
    }
    


}
