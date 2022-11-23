<?php

namespace App\Http\Controllers;

use App\Repositories\LibroRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class LibroController extends Controller
{

    private $libroRepository;

    public function __construct(
        LibroRepository $libroRepository,
    ){
        $this->libroRepository = $libroRepository;
    }
    
    public function index(Request $request)
    {
        $titulo = $this->libroRepository->select2_titulo();
        
        $autor = $this->libroRepository->select2_autor();
        $anio = $this->libroRepository->select2_anio();
        $calificacion = $this->libroRepository->select2_calificacion();

        
        $libros = $this->getLibros($request);
    

        return Inertia::render('Libros', [
            'libros_props' => $libros,
            'titP' => $titulo,
            'autP' => $autor,
            'anioP' => $anio,
            'calP' => $calificacion,
        ]);
    }

    public function getLibros(Request $request)
    {
        $libros = $this->libroRepository->listi($request);
        return $libros;
    }

    public function destroy(Request $request)
    {
        try {
            
            $this->libroRepository->delete($request->id);

            return response()->json([
                'status' => 200,
                'msg' => 'Libro eliminado con éxito',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'msg' => 'Error en el servidor',
            ]);
        }
    }

    public function update(Request $request)
    {
       
        try {
            DB::beginTransaction();
            if (empty($request->id)) {
                $libro = $this->libroRepository->new();
            } else {
                $libro = $this->libroRepository->find($request->id);
            }
            $libro->nombre = $request->nombre;
            $libro->autor = $request->autor;
            $libro->anio = $request->anio;
            $libro->sinopsis = $request->sinopsis;
            $libro->calificacion = $request->calificacion;

            $this->libroRepository->save($libro);

            DB::commit();

            return response()->json(['status' => 200, 'msg' => 'Se han guardado los datos de libro']);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json(['status' => 500, 'msg' => 'Hubo un problema al registrar los datos de libro', 'error' => $th->getMessage(), 'file' => $th->getFile()]);
        }
    }

    public function showLibro(Request $request)
    {
        return $this->billProductRepository->list_by_bill($request);
    }



}
