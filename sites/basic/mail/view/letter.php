 <table   id="bascket_table">


                        <tr bgcolor="#ddd">
                            
                               <th width="80" align="center">название</th> 
                              
                               <th width="100" align="center">кол-во</th> 
                               <th width="90" align="center">цена за шт.</th> 
                               <th width="60" align="center">стоимость</th> 
                              
                
                       </tr>
         <?php foreach ($session['bascket'] as $id => $value) :?>
        
            <tr >
               
                <td><?php echo $value['name_product']?></td>
               
                <td><?php echo $value['count'];?></td>
                <td align="center">$<?php echo  $value['price'];?></td> 
                <td align="center"><?php echo  $value['count']*$value['price'];?></td>
              
            </tr>

           <?php endforeach;?>
           <tr>
            
              <td width="960"></td> 
           </tr>
          
        
    </table>

         <div   class="order_count">Общее кол-во: <strong><?php echo $session['bascket.count'];?></strong> </div>


          <div   class="order_count">Общая стоимость: $ <strong><?php echo $session['bascket.summa'];?></strong> </div>