SELECT SUM(Potencia),
		Consumo = (SELECT SUM(Potencia)  FROM `ValoresRede` 
 WHERE Data = current_date()
) * 0.92
  FROM `ValoresRede` 
 WHERE Data = current_date()


SELECT SUM(Potencia)
  FROM `ValoresRede` 
 WHERE Data = current_date()




SELECT SUM(Potencia/1000) as consumoPotencia, 
((SELECT SUM(Potencia/1000) FROM `ValoresRede` WHERE Data = current_date()) * 0.92 ) as consumo 
FROM `ValoresRede` WHERE Data = current_date()




 <meta http-equiv="refresh" content="5"/>