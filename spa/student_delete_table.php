<div class="row">
	<!-- <div class="col-lg-12 col-md-12 col-sm-12"> -->
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead style="background-color:#057EC5; color:#FFF;">
					<tr>
						<!-- <th style="text-align:center;">Sl.No</th> -->
						<th style="text-align:center;">Roll No</th>
						<th style="text-align:center;">Register No</th>
						<th style="text-align:center;">Name</th>
						<th style="text-align:center;">Major</th>
						<th style="text-align:center;">Batch Code</th>
						<th style="text-align:center;">Delete Student</th>
					</tr>
				</thead>
					<?php
					include "config.php";
					$sql = "SELECT roll_no, reg_no, name, major, batch_code FROM student_personal_details ORDER BY roll_no";;
					$res = $link->query($sql);
					if($res->num_rows>0)
					{
						$i=0;
						while($row = $res->fetch_assoc())
						{
							$i++;
							echo"<tr style='text-align:center;'>";
							// echo"<td>{$i}</td>";
							echo"<td>{$row["roll_no"]}</td>";
							echo"<td>{$row["reg_no"]}</td>";
							echo"<td>{$row["name"]}</td>";
							echo"<td>{$row["major"]}</td>";
							echo"<td>{$row["batch_code"]}</td>";
							echo"<td><button type='button' class='btn btn-sm btn-danger del' data-id={$row["roll_no"]}><i class = 'fa fa-trash-o'></i></td>";
							echo"</tr>";
						}
					}
					else
					{
						echo"<tr>";
						echo"<td colspan = '7' style = 'text-align:left;'>No Admin found...</td>";
						echo"</tr>";
					}
					?>
			</table>
		</div>
	</div>
</div>