<?php
namespace App\Repositories;

use App\Models\Libro;
use Illuminate\Http\Request;

class LibroRepository extends BaseRepository{

    protected $modelBase;

    public function __construct(Libro $modelo)
    {
        $this->modelBase = new BaseRepository($modelo);
        parent::__construct($modelo);   
    }

    public function justList()
    {
        return $this->model->get();
    }

    public function select2_titulo()
    {
        return $this->model->get()->map(function ($value) {
            return [
                'id' => $value->nombre,
                'text' => $value->nombre ?? '',
            ];
        });
    }

    public function select2_anio()
    {
        return $this->model->get()->map(function ($value) {
            return [
                'id' => $value->anio,
                'text' => $value->anio ?? '',
            ];
        });
    }

    public function listi(Request $request)
    {
        return $this->model->where(function ($query) use ($request) {
                if (!empty($request->titulo)) {
                    $query->where('nombre', "$request->titulo");
                }
                if (!empty($request->autor)) {
                    $query->where('autor', "$request->autor");
                }
                if (!empty($request->anio)) {
                    $query->where('anio', "$request->anio");
                }
                if (!empty($request->calificacion)) {
                    $query->where('calificacion', "$request->calificacion");
                }
            })->orderBy('id', 'DESC')->get();
    }

    public function select2_autor()
    {
        return $this->model->get()->map(function ($value) {
            return [
                'id' => $value->autor,
                'text' => $value->autor ?? '',
            ];
        });
    }

    public function select2_calificacion()
    {
        return $this->model->get()->map(function ($value) {
            return [
                'id' => $value->calificacion,
                'text' => $value->calificacion ?? '',
            ];
        });
    }
}

