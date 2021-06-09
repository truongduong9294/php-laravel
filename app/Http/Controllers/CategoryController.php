<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Http\Requests\CategoryRequest;
use Validator;

class CategoryController extends Controller
{
    protected $cateRepo;

    /**
     * Initialization And Depency Injection.
     *
     * @return $cateRepo
     */
    
    public function __construct(CategoryRepositoryInterface $cateRepo)
    {
        $this->cateRepo = $cateRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->cateRepo->getList();
        $checkProduct = $this->cateRepo->checkProduct();
        return view('backend.pages.category.list', ['categories' => $categories, 'checkProduct' => $checkProduct]);
    }

    /**
     * Store a new Category and Edit Category
     *
     * @param  \App\Http\Requests\Request  $request
     * @return Illuminate\Http\Response
     */

    public function process(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'category_name' => 'required|min:4|max:20',
        ]);
        $error_array = array();
        $success_output = '';
        $category = array();
        $dataMode = '';
        if ($validation->fails()) {
            foreach ($validation->messages()->getMessages() as $field_name => $messages) {
                $error_array[] = $messages; 
            }
        }else {
            if ($request->get('button_action') == 'insert') {
                $dataMode = 'insert';
                $category['category_name'] = $request->get('category_name');
                $category = $this->cateRepo->create($category);
                $success_output = '<div class="alert alert-success">Data Inserted</div>';
            }

            if ($request->get('button_action') == 'update') {
                $dataMode = 'update';
                $categoryId = $request->get('category_id');
                $category['category_name'] = $request->get('category_name');
                $category = $this->cateRepo->update($categoryId,$category);
                $success_output = '<div class="alert alert-success">Data Updated</div>';
            }
        }
        $output = array(
            'error'     => $error_array,
            'success'   => $success_output,
            'data'      => $category,
            'dataMode'  => $dataMode
        );
        echo json_encode($output);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function getdata (Request $request)
    {
        $id = $request->input('id');
        $category = $this->cateRepo->find($id);
        $output = array(
            'category_name'    =>  $category->category_name,
        );
        echo json_encode($output);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */

    public function delete(Request $request) 
    {
        $success_output = '';
        $category = $this->cateRepo->delete($request->input('id'));
        if ($category) {
            $success_output = 'Data Deleted';
        }
        $output = array(
            'success_output' => $success_output
        );
        return json_encode($output);
    }
}
