<?php
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use App\Repositories\Category\CategoryRepositoryInterface;
    
    class BaseController extends Controller
    {
        protected $cateRepo;

        public function __construct(CategoryRepositoryInterface $cateRepo)
            {
                $this->cateRepo = $cateRepo;
                $categories = $this->cateRepo->listCate();
                View::share('categories', $categories);
            }
        }
?>