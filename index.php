<?
include "../../../index.php";
?>
<h2>Журнал заведения новых ТИ</h2>
<table width=100% class="grid">
	<tr>
		<th>AVNR</th>
		<th>TID</th>
		<th>Название</th>
		<th>Дата создания</th>
	</tr>
<?
$szSQL = "
select avnr, tid, name, t
  from (select e_mw_bez.avnr avnr, 
               tid2text(oid2tid(e_mw_bez.oid)) tid,
               vtrim(e_mw_bez.bmtext) name, 
               j_arc_creator.t t
          from j_arc_creator, e_mw_bez
         where e_mw_bez.avnr = j_arc_creator.avnr
           and e_mw_bez.onl != 0
         order by j_arc_creator.id desc) t1
 where rownum < 200";
$stmt = ociparse($dbid, $szSQL);
ociexecute($stmt);
$i = 0;
while(ocifetch($stmt)){
  $_nAVNR = ociresult($stmt, "AVNR");
  $_szTID = ociresult($stmt, "TID");
  $_szName = ociresult($stmt, "NAME");
  $_t = ociresult($stmt, "T");
  $_szDateTime = date("d/m/Y H:i:s", $_t);
  //$szStyle = $i % 2 ? "style=\"background-color: #ffa;\"" : "";
  echo "<tr $szStyle>";
  echo "<td align=center>$_nAVNR</td>";
  echo "<td align=center>$_szTID</td>";
  echo "<td>$_szName</td>";
  echo "<td align=center>$_szDateTime</td>";
  echo "</tr>";
  $i ++;
}
?>
</table>
