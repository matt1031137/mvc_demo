<?php
/**
 * PostController
 * 負責處理跟「文章」相關的請求, 串接 Model 和 View
 */


//在app/config/config.php內已經有預設'DEFAULT_CONTROLLER', 'Post'(目前範例也只有PostController.php)跟預設define('DEFAULT_ACTION', 'index');
//等於是如果網址只有網域名稱後面什麼都沒帶的場合=>預設跑到首頁(文章列表頁)


//因為抽象的core/Controller.php內定義的就包含呼叫view(畫面)跟modal(資料庫)的方法了，這邊只要依照不同的屬性(index或show)就能各自處理兩種頁面了
class PostController extends Controller
{
    /**
     * 文章列表頁
     * 對應網址: /post 或 /post/index
     */
    public function index(): void
    {
        //abstract class Controller 內的model屬性(函式)，以此建立/models/Post.php內的Post實例
        $postModel = $this->model('Post');
        //再用建立的Post實例，跑getAll()屬性(函式)，大概看是連線資料庫抓所有文章的邏輯，詳細看Post.php時再解析
        $posts = $postModel->getAll();

        // abstract class Controller 內的view屬性，自動拉/views/post/index.php的預設版面，並放入title變數跟剛才拉資料庫的全部文章變數
        $this->view('post/index', [
            'title' => '文章列表',
            'posts' => $posts,
        ]);
    }

    /**
     * 文章詳細頁
     * 對應網址: /post/show/1   ($id = 1)
     */
    public function show(int $id): void
    {
        //abstract class Controller 內的model屬性(函式)，以此建立/models/Post.php內的Post實例
        $postModel = $this->model('Post');
        //再用建立的Post實例，跑getById($id)屬性(函式)，大概看應該是靠id拉資料庫的單一文章資料，詳細看Post.php時再解析
        $post = $postModel->getById($id);

        //如果在model查無該篇文章，回傳404印出錯誤訊息並return
        if ($post === null) {
            http_response_code(404);
            echo '文章不存在';
            return;
        }

        //找到文章的場合，跑abstract class Controller 內的view屬性，自動拉/views/post/show.php的預設版面，並放入title變數跟剛才拉資料庫的單一文章變數
        $this->view('post/show', [
            'title' => $post['title'],
            'post'  => $post,
        ]);
    }
}
