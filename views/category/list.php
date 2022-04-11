<h2 class="text-center">List categories</h2>
<table class="table">
    <thead>
    <tr>
        <th>id</th>
        <th>title</th>
        <th>description</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
        <?php
            if(isset($categories)){
                foreach ($categories as $category){
                   echo '<tr>';
                   echo '<td>'.$category->id_category_post.'</td>';
                   echo '<td>'.$category->title_category_post.'</td>';
                   echo '<td>'.$category->desc_category_post.'</td>';
                   echo '<td>
                            <a href="/php_basic_framework/category/edit/'.$category->id_category_post.'"><i class="bi bi-pencil-square"></i></a> |
                            <a href="/php_basic_framework/category/delete/'.$category->id_category_post.'"><i class="bi bi-trash "></i></a>
                        </td>';
                   echo '</tr>';
                }
            }

        ?>
    </tbody>
</table>
<a href="<?=BASE_URL.'/home'?>" class="btn btn-secondary">Back</a>
