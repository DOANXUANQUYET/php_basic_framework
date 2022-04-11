<h1 class="text-center">Update post</h1>
<form action="<?=BASE_URL.'/post/update'?>" method="post">
    <div class="form-group">
        <label for="post_title">Post title:</label>
        <input type="text" class="form-control" name="post_title" id="post_title" value="<?=$post[0]->post_title?>">
        <input type="hidden" name="id_post" value="<?=$post[0]->id_post?>">
    </div>
    <div class="form-group">
        <label for="id_category_post">Post category:</label>
        <select class="form-control" id="id_category_post" name="id_category_post">
            <?php
                if(isset($categories)){
                    foreach ($categories as $category){
                        if($category->id_category_post == $post[0]->id_category_post){
                            echo '<option value="'.$category->id_category_post.'" selected >'.$category->title_category_post.'</option>';
                        }else{
                            echo '<option value="'.$category->id_category_post.'">'.$category->title_category_post.'</option>';
                        }
                    }
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_content">Post content:</label>
        <textarea class="form-control" rows="5" name="post_content" id="post_content"><?=$post[0]->post_content?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="<?=BASE_URL.'/home'?>" class="btn btn-secondary">Back</a>
</form>
