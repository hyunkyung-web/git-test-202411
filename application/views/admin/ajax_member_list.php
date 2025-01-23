<?php 

foreach($data as $row){?>
<tr>
	<td>
		<label>
			<input type="checkbox" class="display-none" name="chk_address" id="chk_<?php echo $row["cellphone"]?>" data-email="<?php echo $row["member_email"]?>" data-cellphone="<?php echo $row["cellphone"]?>" title="<?php echo $row["member_nm"]?>"  onclick="javascript: clickChkbox(this);" <?php echo mb_strpos($fix_target, $row["cellphone"]) > -1 ? 'checked' : '';?>/>
			<span class="custom-checkbox"></span>
		</label>
	</td>
	<td class="left"><label for="chk_<?php echo $row["cellphone"]?>"><?php echo $row["member_nm"].'('.$row["member_email"].')'?></label></td>
</tr><?php
}?>



