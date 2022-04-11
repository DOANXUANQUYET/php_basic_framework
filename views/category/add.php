<h1 class="text-center">Add new category</h1>
<form action="<?=BASE_URL.'/category/create'?>" method="post">
    <div class="form-group">
        <label for="title_category_post">Category title:</label>
        <input type="text" class="form-control" name="title_category_post" id="title_category_post">
    </div>
    <div class="form-group">
        <label for="desc_category_post">Category description:</label>
        <textarea class="form-control" rows="5" name="desc_category_post" id="desc_category_post"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="<?=BASE_URL.'/home'?>" class="btn btn-secondary">Back</a>
</form>
