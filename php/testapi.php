<?php
	$day="SELECT dailysalemaster.subbranchid,(SELECT COUNT(dailysalemaster.dmid) FROM dailysalemaster WHERE dailysalemaster.subbranchid = 74 AND dailysalemaster.masterdate >= '2018-05-01 00:00:00' AND dailysalemaster.masterdate <= '2018-05-01 23:59:59') AS totalbill,SUM(stock.costprice*dailysaledetail.qty) AS totalcost,(SUM(dailysalemaster.sumprice)-SUM(stock.costprice*dailysaledetail.qty)) AS totalprofit,SUM(dailysalemaster.sumprice) AS totalsale,('2018-05-01 23:59:59') AS date FROM dailysalemaster,dailysaledetail,stock WHERE stock.sid = dailysaledetail.stockid AND dailysaledetail.masterid = dailysalemaster.dmid AND dailysalemaster.subbranchid = 74 AND dailysalemaster.masterdate >= '2018-05-01 00:00:00' AND dailysalemaster.masterdate <= '2018-05-01 23:59:59'";

?>
