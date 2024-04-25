SELECT 
  a.`ID_PERMOHONAN`,
b.*
FROM
  `r_permohonan_izin` a 
  LEFT JOIN `migas_iu_pengangkutan_darat_minyak_bumi_tetap_baru` b 
    ON a.`ID_PERMOHONAN` = b.`ID_PERMOHONAN`
WHERE 
  a.`ID_PERMOHONAN` IS NOT NULL AND 
  b.`ID_PERMOHONAN` IS NOT NULL
  AND a.`ID_TEMPLATE`IN('1119','1112')
  AND a.`LIST_SUB_PAGE` IN('633','654')
  AND a.`ID_CURR_PROSES`='140'
GROUP BY 
  a.`ID_PERMOHONAN`, b.`NOMOR_KENDARAAN`;
  
  
  
SELECT 
  a.`ID_PERMOHONAN`,
b.*
FROM
  `r_permohonan_izin` a 
  LEFT JOIN `migas_iu_pengangkutan_darat_minyak_bumi_tetap_baru_inv_tab` b 
    ON a.`ID_PERMOHONAN` = b.`ID_PERMOHONAN`
WHERE 
  a.`ID_PERMOHONAN` IS NOT NULL AND 
  b.`ID_PERMOHONAN` IS NOT NULL
  AND a.`ID_TEMPLATE`IN('1119','1112')
  AND a.`LIST_SUB_PAGE` IN('633','654')
  AND a.`ID_CURR_PROSES`='140'
GROUP BY 
  a.`ID_PERMOHONAN`;
  
  
  
  SELECT 
  a.`ID_PERMOHONAN`,
b.*
FROM
  `r_permohonan_izin` a 
  LEFT JOIN `migas_iu_pengangkutan_minyak_bumi_tingkat_komponen_darat_tab` b 
    ON a.`ID_PERMOHONAN` = b.`ID_PERMOHONAN`
WHERE 
  a.`ID_PERMOHONAN` IS NOT NULL AND 
  b.`ID_PERMOHONAN` IS NOT NULL
  AND a.`ID_TEMPLATE`IN('1119','1112')
  AND a.`LIST_SUB_PAGE` IN('633','654')
  AND a.`ID_CURR_PROSES`='140'
GROUP BY 
  a.`ID_PERMOHONAN`;
  
  
  
