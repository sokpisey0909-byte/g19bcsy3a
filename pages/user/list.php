<div class="contain">
    <div>
        <h3> User List</h3>
        <a href="./?page=user/create" role="button" class="btn btn-success">Create New</a>

    </div>
    <table class="table table-responsive">
        <table class="table table-striped-">
            <tr>
                <th>ID</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Option</th>
                
            </tr>

            <?php
                
                $users = getUsers();
                if($users){
                    $count = 1;
                    while($row = $users->fetch_object()){
                        echo '<tr>
                                <td>'.$count++.'</td>
                                <th>

                                <img src="'.($row->photo ?? './assets/img/image.jpg').'"
                                 class="rounded img-thumbnail" style="max-width: 100px;">

                                </td>
 
                                <td>'.$row->name.'</td>
                                <td>
                                <a href="./?page=user/update&id=' . $row->id . '" 
                                role="button" class="btn btn-primary">
                                    Update
                                </a>
                                <a href="./?page=user/deleted&id=' . $row->id . '" 
                                role="button" class="btn btn-danger">
                                    Delete
                                </a> 
                                
                            </tr>';
                            
                            $count++;
                            
                        
                    }
                    
                }
            ?>
        </table>
        </thead>
    </table>

</div>