use bincomphptest;

select polling_unit_uniqueid, polling_unit_name, party_abbreviation, party_score
from announced_pu_results
inner join polling_unit
on polling_unit.uniqueid = announced_pu_results.polling_unit_uniqueid
order by announced_pu_results.polling_unit_uniqueid;

select * from announced_pu_results;
/*Query to get all lga and its pu */
select polling_unit.uniqueid, polling_unit_name, polling_unit.lga_id, lga_name, sum(party_score) as total_result
from announced_pu_results
inner join polling_unit
on polling_unit.uniqueid = announced_pu_results.polling_unit_uniqueid
inner join lga
on polling_unit.lga_id = lga.lga_id
group by announced_pu_results.polling_unit_uniqueid
order by lga.lga_id;



select polling_unit.uniqueid, polling_unit_name, polling_unit.lga_id, lga_name, sum(party_score) as total_result
from announced_pu_results
inner join polling_unit
on polling_unit.uniqueid = announced_pu_results.polling_unit_uniqueid
inner join lga
on polling_unit.lga_id = lga.lga_id
where lga.lga_id = 17
group by announced_pu_results.polling_unit_uniqueid;

SELECT * FROM bincomphptest.polling_unit;
select * from announced_pu_results 
where polling_unit_uniqueid = 108; 