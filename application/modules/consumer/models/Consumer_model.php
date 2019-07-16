<?php
 class Consumer_model extends CI_Model {
     function __construct() {
         parent::__construct();
     }
	 
     
    function save_consumer_selection_criteria($frmData) {   
        $user_id = $this->session->userdata('admin_user_id');
        
        if (!empty($frmData['criteria_id'])) {
           
                $UpdateData = array(
                    "customer_id" => $user_id,
					"unique_system_selection_criteria_id" => $frmData['unique_system_selection_criteria_id'],
					"name_of_selection_criteria" => $frmData['name_of_selection_criteria'],
                    //"promotion_type" => $frmData['promotion_type'],
                    "consumer_gender" => $frmData['consumer_gender'],
					"consumer_min_age" => $frmData['consumer_min_age'],
                    "consumer_max_age" => $frmData['consumer_max_age'],
                    "consumer_city" => $frmData['consumer_city'],
                    "consumer_pin" => "123456",
					"updated_by_id" => $user_id,
					"update_date" => date('Y-m-d H:i:s'),
                    "status" => 1,
					"city_registration" 	=> $frmData['city_registration'],
					"earned_loyalty_points" => $frmData['earned_loyalty_points'],
					"monthly_earnings" 		=> $frmData['monthly_earnings'],
					"job_profile" 			=> $frmData['job_profile'],
					"education_qualification" => $frmData['education_qualification'],
					"type_vehicle" 			=> $frmData['type_vehicle'],
					"profession" 			=> $frmData['profession'],
					"marital_status" 		=> $frmData['marital_status'],
					"no_of_family_members" => $frmData['no_of_family_members'],
					"loan_car" 				=> $frmData['loan_car'],
					"loan_housing" 			=> $frmData['loan_housing'],
					"personal_loan" 		=> $frmData['personal_loan'],
					"credit_card_loan" 		=> $frmData['credit_card_loan'],
					"own_a_car" 			=> $frmData['own_a_car'],
					"house_type" 			=> $frmData['house_type'],
					"last_location" 		=> $frmData['last_location'],
					"life_insurance" 		=> $frmData['life_insurance'],
					"medical_insurance" 	=> $frmData['medical_insurance'],
					"height_in_inches" 		=> $frmData['height_in_inches'],
					"weight_in_kg" 			=> $frmData['weight_in_kg'],
					"hobbies" 				=> $frmData['hobbies'],
					"sports" 				=> $frmData['sports'],
					"entertainment" 		=> $frmData['entertainment'],
					"spouse_gender" 		=> $frmData['spouse_gender'],
					"spouse_phone" 			=> $frmData['spouse_phone'],
					"spouse_dob" 			=> $frmData['spouse_dob'],
					"marriage_anniversary" 	=> $frmData['marriage_anniversary'],
					"spouse_work_status" 	=> $frmData['spouse_work_status'],
					"spouse_edu_qualification" => $frmData['spouse_edu_qualification'],
					"spouse_monthly_income" => $frmData['spouse_monthly_income'],
					"spouse_loan" => $frmData['spouse_loan'],
					"spouse_personal_loan" => $frmData['spouse_personal_loan'],
					"spouse_credit_card_loan" => $frmData['spouse_credit_card_loan'],
					"spouse_own_a_car" 		=> $frmData['spouse_own_a_car'],
					"spouse_house_type" 	=> $frmData['spouse_house_type'],
					"spouse_height_inches" 	=> $frmData['spouse_height_inches'],
					"spouse_weight_kg" 		=> $frmData['spouse_weight_kg'],
					"spouse_hobbies" 		=> $frmData['spouse_hobbies'],
					"spouse_sports" 		=> $frmData['spouse_sports'],
					"spouse_entertainment" 	=> $frmData['spouse_entertainment'],
					"field_1" => $frmData['field_1'],
					"field_2" => $frmData['field_2'],
					"field_3" => $frmData['field_3'],
					"field_4" => $frmData['field_4'],
					"field_5" => $frmData['field_5'],
					"field_6" => $frmData['field_6'],
					"field_7" => $frmData['field_7'],
					"field_8" => $frmData['field_8'],
					"field_9" => $frmData['field_9'],
					"field_10" => $frmData['field_10'],
					"field_11" => $frmData['field_11'],
					"field_12" => $frmData['field_12'],
					"field_13" => $frmData['field_13'],
					"field_14" => $frmData['field_14'],
					"field_15" => $frmData['field_15'],
					"field_16" => $frmData['field_16'],
					"field_17" => $frmData['field_17'],
					"field_18" => $frmData['field_18'],
					"field_19" => $frmData['field_19'],
					"field_20" => $frmData['field_20'],
					"field_21" => $frmData['field_21'],
					"field_22" => $frmData['field_22'],
					"field_23" => $frmData['field_23'],
					"field_24" => $frmData['field_24'],
					"field_25" => $frmData['field_25'],
					"field_26" => $frmData['field_26'],
					"field_27" => $frmData['field_27'],
					"field_28" => $frmData['field_28'],
					"field_29" => $frmData['field_29'],
					"field_30" => $frmData['field_30'],
					"field_31" => $frmData['field_31'],
					"field_32" => $frmData['field_32'],
					"field_33" => $frmData['field_33'],
					"field_34" => $frmData['field_34'],
					"field_35" => $frmData['field_35'],
					"field_36" => $frmData['field_36'],
					"field_37" => $frmData['field_37'],
					"field_38" => $frmData['field_38'],
					"field_39" => $frmData['field_39'],
					"field_40" => $frmData['field_40'],
					"field_41" => $frmData['field_41'],
					"field_42" => $frmData['field_42'],
					"field_43" => $frmData['field_43'],
					"field_44" => $frmData['field_44'],
					"field_45" => $frmData['field_45'],
					"field_46" => $frmData['field_46'],
					"field_47" => $frmData['field_47'],
					"field_48" => $frmData['field_48'],
					"field_49" => $frmData['field_49'],
					"field_50" => $frmData['field_50'],
					"field_51" => $frmData['field_51'],
					"field_52" => $frmData['field_52'],
					"field_53" => $frmData['field_53'],
					"field_54" => $frmData['field_54'],
					"field_55" => $frmData['field_55'],
					"field_56" => $frmData['field_56'],
					"field_57" => $frmData['field_57'],
					"field_58" => $frmData['field_58'],
					"field_59" => $frmData['field_59'],
					"field_60" => $frmData['field_60'],
					"field_61" => $frmData['field_61'],
					"field_62" => $frmData['field_62'],
					"field_63" => $frmData['field_63'],
					"field_64" => $frmData['field_64'],
					"field_65" => $frmData['field_65'],
					"field_66" => $frmData['field_66'],
					"field_67" => $frmData['field_67'],
					"field_68" => $frmData['field_68'],
					"field_69" => $frmData['field_69'],
					"field_70" => $frmData['field_70'],
					"field_71" => $frmData['field_71'],
					"field_72" => $frmData['field_72'],
					"field_73" => $frmData['field_73'],
					"field_74" => $frmData['field_74'],
					"field_75" => $frmData['field_75'],
					"field_76" => $frmData['field_76'],
					"field_77" => $frmData['field_77'],
					"field_78" => $frmData['field_78'],
					"field_79" => $frmData['field_79'],
					"field_80" => $frmData['field_80'],
					"field_81" => $frmData['field_81'],
					"field_82" => $frmData['field_82'],
					"field_83" => $frmData['field_83'],
					"field_84" => $frmData['field_84'],
					"field_85" => $frmData['field_85'],
					"field_86" => $frmData['field_86'],
					"field_87" => $frmData['field_87'],
					"field_88" => $frmData['field_88'],
					"field_89" => $frmData['field_89'],
					"field_90" => $frmData['field_90'],
					"field_91" => $frmData['field_91'],
					"field_92" => $frmData['field_92'],
					"field_93" => $frmData['field_93'],
					"field_94" => $frmData['field_94'],
					"field_95" => $frmData['field_95'],
					"field_96" => $frmData['field_96'],
					"field_97" => $frmData['field_97'],
					"field_98" => $frmData['field_98'],
					"field_99" => $frmData['field_99'],
					"field_100" => $frmData['field_100'],
					"field_101" => $frmData['field_101'],
					"field_102" => $frmData['field_102'],
					"field_103" => $frmData['field_103'],
					"field_104" => $frmData['field_104'],
					"field_105" => $frmData['field_105'],
					"field_106" => $frmData['field_106'],
					"field_107" => $frmData['field_107'],
					"field_108" => $frmData['field_108'],
					"field_109" => $frmData['field_109'],
					"field_110" => $frmData['field_110'],
					"field_111" => $frmData['field_111'],
					"field_112" => $frmData['field_112'],
					"field_113" => $frmData['field_113'],
					"field_114" => $frmData['field_114'],
					"field_115" => $frmData['field_115'],
					"field_116" => $frmData['field_116'],
					"field_117" => $frmData['field_117'],
					"field_118" => $frmData['field_118'],
					"field_119" => $frmData['field_119'],
					"field_120" => $frmData['field_120'],
					"field_121" => $frmData['field_121'],
					"field_122" => $frmData['field_122'],
					"field_123" => $frmData['field_123'],
					"field_124" => $frmData['field_124'],
					"field_125" => $frmData['field_125'],
					"field_126" => $frmData['field_126'],
					"field_127" => $frmData['field_127'],
					"field_128" => $frmData['field_128'],
					"field_129" => $frmData['field_129'],
					"field_130" => $frmData['field_130'],
					"field_131" => $frmData['field_131'],
					"field_132" => $frmData['field_132'],
					"field_133" => $frmData['field_133'],
					"field_134" => $frmData['field_134'],
					"field_135" => $frmData['field_135'],
					"field_136" => $frmData['field_136'],
					"field_137" => $frmData['field_137'],
					"field_138" => $frmData['field_138'],
					"field_139" => $frmData['field_139'],
					"field_140" => $frmData['field_140'],
					"field_141" => $frmData['field_141'],
					"field_142" => $frmData['field_142'],
					"field_143" => $frmData['field_143'],
					"field_144" => $frmData['field_144'],
					"field_145" => $frmData['field_145'],
					"field_146" => $frmData['field_146'],
					"field_147" => $frmData['field_147'],
					"field_148" => $frmData['field_148'],
					"field_149" => $frmData['field_149'],
					"field_150" => $frmData['field_150'],
					"field_151" => $frmData['field_151'],
					"field_152" => $frmData['field_152'],
					"field_153" => $frmData['field_153'],
					"field_154" => $frmData['field_154'],
					"field_155" => $frmData['field_155'],
					"field_156" => $frmData['field_156'],
					"field_157" => $frmData['field_157'],
					"field_158" => $frmData['field_158'],
					"field_159" => $frmData['field_159'],
					"field_160" => $frmData['field_160'],
					"field_161" => $frmData['field_161'],
					"field_162" => $frmData['field_162'],
					"field_163" => $frmData['field_163'],
					"field_164" => $frmData['field_164'],
					"field_165" => $frmData['field_165'],
					"field_166" => $frmData['field_166'],
					"field_167" => $frmData['field_167'],
					"field_168" => $frmData['field_168'],
					"field_169" => $frmData['field_169'],
					"field_170" => $frmData['field_170'],
					"field_171" => $frmData['field_171'],
					"field_172" => $frmData['field_172'],
					"field_173" => $frmData['field_173'],
					"field_174" => $frmData['field_174'],
					"field_175" => $frmData['field_175'],
					"field_176" => $frmData['field_176'],
					"field_177" => $frmData['field_177'],
					"field_178" => $frmData['field_178'],
					"field_179" => $frmData['field_179'],
					"field_180" => $frmData['field_180'],
					"field_181" => $frmData['field_181'],
					"field_182" => $frmData['field_182'],
					"field_183" => $frmData['field_183'],
					"field_184" => $frmData['field_184'],
					"field_185" => $frmData['field_185'],
					"field_186" => $frmData['field_186'],
					"field_187" => $frmData['field_187'],
					"field_188" => $frmData['field_188'],
					"field_189" => $frmData['field_189'],
					"field_190" => $frmData['field_190'],
					"field_191" => $frmData['field_191'],
					"field_192" => $frmData['field_192'],
					"field_193" => $frmData['field_193'],
					"field_194" => $frmData['field_194'],
					"field_195" => $frmData['field_195'],
					"field_196" => $frmData['field_196'],
					"field_197" => $frmData['field_197'],
					"field_198" => $frmData['field_198'],
					"field_199" => $frmData['field_199'],
					"field_200" => $frmData['field_200'],
					"field_201" => $frmData['field_201']                    
                );
            
            //$this->db->insert("assign_plants_to_users", $insertData);
            $whereData = array(
                'criteria_id' => $frmData['criteria_id']
            );

            $this->db->set($UpdateData);
            $this->db->where($whereData);
            if ($this->db->update('consumer_selection_criteria')) {
                //echo '***'.$this->db->last_query();exit;
                $this->session->set_flashdata('success', 'Consumer Selection Criteria Updated Successfully!');
                return 1;
            }
        } else {
            
            $insertData = array(
					"customer_id" 			=> $user_id,
					"unique_system_selection_criteria_id" => $frmData['unique_system_selection_criteria_id'],
					"name_of_selection_criteria" => $frmData['name_of_selection_criteria'],                    
                    //"promotion_type" 		=> $frmData['promotion_type'],
                    "consumer_gender" 		=> $frmData['consumer_gender'],
					"consumer_min_age" 		=> $frmData['consumer_min_age'],
                    "consumer_max_age" 		=> $frmData['consumer_max_age'],
                    "consumer_city" 		=> $frmData['consumer_city'],
                    "consumer_pin" 			=> "12345",
					"created_by_id" 		=> $user_id,
					"create_date" 			=> date('Y-m-d H:i:s'),
                    "status" 				=> 1,
					"city_registration" 	=> $frmData['city_registration'],
					"earned_loyalty_points" => $frmData['earned_loyalty_points'],
					"monthly_earnings" 		=> $frmData['monthly_earnings'],
					"job_profile" 			=> $frmData['job_profile'],
					"education_qualification" => $frmData['education_qualification'],
					"type_vehicle" 			=> $frmData['type_vehicle'],
					"profession" 			=> $frmData['profession'],
					"marital_status" 		=> $frmData['marital_status'],
					"no_of_family_members" => $frmData['no_of_family_members'],
					"loan_car" 				=> $frmData['loan_car'],
					"loan_housing" 			=> $frmData['loan_housing'],
					"personal_loan" 		=> $frmData['personal_loan'],
					"credit_card_loan" 		=> $frmData['credit_card_loan'],
					"own_a_car" 			=> $frmData['own_a_car'],
					"house_type" 			=> $frmData['house_type'],
					"last_location" 		=> $frmData['last_location'],
					"life_insurance" 		=> $frmData['life_insurance'],
					"medical_insurance" 	=> $frmData['medical_insurance'],
					"height_in_inches" 		=> $frmData['height_in_inches'],
					"weight_in_kg" 			=> $frmData['weight_in_kg'],
					"hobbies" 				=> $frmData['hobbies'],
					"sports" 				=> $frmData['sports'],
					"entertainment" 		=> $frmData['entertainment'],
					"spouse_gender" 		=> $frmData['spouse_gender'],
					"spouse_phone" 			=> $frmData['spouse_phone'],
					"spouse_dob" 			=> $frmData['spouse_dob'],
					"marriage_anniversary" 	=> $frmData['marriage_anniversary'],
					"spouse_work_status" 	=> $frmData['spouse_work_status'],
					"spouse_edu_qualification" => $frmData['spouse_edu_qualification'],
					"spouse_monthly_income" => $frmData['spouse_monthly_income'],
					"spouse_loan" => $frmData['spouse_loan'],
					"spouse_personal_loan" => $frmData['spouse_personal_loan'],
					"spouse_credit_card_loan" => $frmData['spouse_credit_card_loan'],
					"spouse_own_a_car" 		=> $frmData['spouse_own_a_car'],
					"spouse_house_type" 	=> $frmData['spouse_house_type'],
					"spouse_height_inches" 	=> $frmData['spouse_height_inches'],
					"spouse_weight_kg" 		=> $frmData['spouse_weight_kg'],
					"spouse_hobbies" 		=> $frmData['spouse_hobbies'],
					"spouse_sports" 		=> $frmData['spouse_sports'],
					"spouse_entertainment" 	=> $frmData['spouse_entertainment'],
					"field_1" => $frmData['field_1'],
					"field_2" => $frmData['field_2'],
					"field_3" => $frmData['field_3'],
					"field_4" => $frmData['field_4'],
					"field_5" => $frmData['field_5'],
					"field_6" => $frmData['field_6'],
					"field_7" => $frmData['field_7'],
					"field_8" => $frmData['field_8'],
					"field_9" => $frmData['field_9'],
					"field_10" => $frmData['field_10'],
					"field_11" => $frmData['field_11'],
					"field_12" => $frmData['field_12'],
					"field_13" => $frmData['field_13'],
					"field_14" => $frmData['field_14'],
					"field_15" => $frmData['field_15'],
					"field_16" => $frmData['field_16'],
					"field_17" => $frmData['field_17'],
					"field_18" => $frmData['field_18'],
					"field_19" => $frmData['field_19'],
					"field_20" => $frmData['field_20'],
					"field_21" => $frmData['field_21'],
					"field_22" => $frmData['field_22'],
					"field_23" => $frmData['field_23'],
					"field_24" => $frmData['field_24'],
					"field_25" => $frmData['field_25'],
					"field_26" => $frmData['field_26'],
					"field_27" => $frmData['field_27'],
					"field_28" => $frmData['field_28'],
					"field_29" => $frmData['field_29'],
					"field_30" => $frmData['field_30'],
					"field_31" => $frmData['field_31'],
					"field_32" => $frmData['field_32'],
					"field_33" => $frmData['field_33'],
					"field_34" => $frmData['field_34'],
					"field_35" => $frmData['field_35'],
					"field_36" => $frmData['field_36'],
					"field_37" => $frmData['field_37'],
					"field_38" => $frmData['field_38'],
					"field_39" => $frmData['field_39'],
					"field_40" => $frmData['field_40'],
					"field_41" => $frmData['field_41'],
					"field_42" => $frmData['field_42'],
					"field_43" => $frmData['field_43'],
					"field_44" => $frmData['field_44'],
					"field_45" => $frmData['field_45'],
					"field_46" => $frmData['field_46'],
					"field_47" => $frmData['field_47'],
					"field_48" => $frmData['field_48'],
					"field_49" => $frmData['field_49'],
					"field_50" => $frmData['field_50'],
					"field_51" => $frmData['field_51'],
					"field_52" => $frmData['field_52'],
					"field_53" => $frmData['field_53'],
					"field_54" => $frmData['field_54'],
					"field_55" => $frmData['field_55'],
					"field_56" => $frmData['field_56'],
					"field_57" => $frmData['field_57'],
					"field_58" => $frmData['field_58'],
					"field_59" => $frmData['field_59'],
					"field_60" => $frmData['field_60'],
					"field_61" => $frmData['field_61'],
					"field_62" => $frmData['field_62'],
					"field_63" => $frmData['field_63'],
					"field_64" => $frmData['field_64'],
					"field_65" => $frmData['field_65'],
					"field_66" => $frmData['field_66'],
					"field_67" => $frmData['field_67'],
					"field_68" => $frmData['field_68'],
					"field_69" => $frmData['field_69'],
					"field_70" => $frmData['field_70'],
					"field_71" => $frmData['field_71'],
					"field_72" => $frmData['field_72'],
					"field_73" => $frmData['field_73'],
					"field_74" => $frmData['field_74'],
					"field_75" => $frmData['field_75'],
					"field_76" => $frmData['field_76'],
					"field_77" => $frmData['field_77'],
					"field_78" => $frmData['field_78'],
					"field_79" => $frmData['field_79'],
					"field_80" => $frmData['field_80'],
					"field_81" => $frmData['field_81'],
					"field_82" => $frmData['field_82'],
					"field_83" => $frmData['field_83'],
					"field_84" => $frmData['field_84'],
					"field_85" => $frmData['field_85'],
					"field_86" => $frmData['field_86'],
					"field_87" => $frmData['field_87'],
					"field_88" => $frmData['field_88'],
					"field_89" => $frmData['field_89'],
					"field_90" => $frmData['field_90'],
					"field_91" => $frmData['field_91'],
					"field_92" => $frmData['field_92'],
					"field_93" => $frmData['field_93'],
					"field_94" => $frmData['field_94'],
					"field_95" => $frmData['field_95'],
					"field_96" => $frmData['field_96'],
					"field_97" => $frmData['field_97'],
					"field_98" => $frmData['field_98'],
					"field_99" => $frmData['field_99'],
					"field_100" => $frmData['field_100'],
					"field_101" => $frmData['field_101'],
					"field_102" => $frmData['field_102'],
					"field_103" => $frmData['field_103'],
					"field_104" => $frmData['field_104'],
					"field_105" => $frmData['field_105'],
					"field_106" => $frmData['field_106'],
					"field_107" => $frmData['field_107'],
					"field_108" => $frmData['field_108'],
					"field_109" => $frmData['field_109'],
					"field_110" => $frmData['field_110'],
					"field_111" => $frmData['field_111'],
					"field_112" => $frmData['field_112'],
					"field_113" => $frmData['field_113'],
					"field_114" => $frmData['field_114'],
					"field_115" => $frmData['field_115'],
					"field_116" => $frmData['field_116'],
					"field_117" => $frmData['field_117'],
					"field_118" => $frmData['field_118'],
					"field_119" => $frmData['field_119'],
					"field_120" => $frmData['field_120'],
					"field_121" => $frmData['field_121'],
					"field_122" => $frmData['field_122'],
					"field_123" => $frmData['field_123'],
					"field_124" => $frmData['field_124'],
					"field_125" => $frmData['field_125'],
					"field_126" => $frmData['field_126'],
					"field_127" => $frmData['field_127'],
					"field_128" => $frmData['field_128'],
					"field_129" => $frmData['field_129'],
					"field_130" => $frmData['field_130'],
					"field_131" => $frmData['field_131'],
					"field_132" => $frmData['field_132'],
					"field_133" => $frmData['field_133'],
					"field_134" => $frmData['field_134'],
					"field_135" => $frmData['field_135'],
					"field_136" => $frmData['field_136'],
					"field_137" => $frmData['field_137'],
					"field_138" => $frmData['field_138'],
					"field_139" => $frmData['field_139'],
					"field_140" => $frmData['field_140'],
					"field_141" => $frmData['field_141'],
					"field_142" => $frmData['field_142'],
					"field_143" => $frmData['field_143'],
					"field_144" => $frmData['field_144'],
					"field_145" => $frmData['field_145'],
					"field_146" => $frmData['field_146'],
					"field_147" => $frmData['field_147'],
					"field_148" => $frmData['field_148'],
					"field_149" => $frmData['field_149'],
					"field_150" => $frmData['field_150'],
					"field_151" => $frmData['field_151'],
					"field_152" => $frmData['field_152'],
					"field_153" => $frmData['field_153'],
					"field_154" => $frmData['field_154'],
					"field_155" => $frmData['field_155'],
					"field_156" => $frmData['field_156'],
					"field_157" => $frmData['field_157'],
					"field_158" => $frmData['field_158'],
					"field_159" => $frmData['field_159'],
					"field_160" => $frmData['field_160'],
					"field_161" => $frmData['field_161'],
					"field_162" => $frmData['field_162'],
					"field_163" => $frmData['field_163'],
					"field_164" => $frmData['field_164'],
					"field_165" => $frmData['field_165'],
					"field_166" => $frmData['field_166'],
					"field_167" => $frmData['field_167'],
					"field_168" => $frmData['field_168'],
					"field_169" => $frmData['field_169'],
					"field_170" => $frmData['field_170'],
					"field_171" => $frmData['field_171'],
					"field_172" => $frmData['field_172'],
					"field_173" => $frmData['field_173'],
					"field_174" => $frmData['field_174'],
					"field_175" => $frmData['field_175'],
					"field_176" => $frmData['field_176'],
					"field_177" => $frmData['field_177'],
					"field_178" => $frmData['field_178'],
					"field_179" => $frmData['field_179'],
					"field_180" => $frmData['field_180'],
					"field_181" => $frmData['field_181'],
					"field_182" => $frmData['field_182'],
					"field_183" => $frmData['field_183'],
					"field_184" => $frmData['field_184'],
					"field_185" => $frmData['field_185'],
					"field_186" => $frmData['field_186'],
					"field_187" => $frmData['field_187'],
					"field_188" => $frmData['field_188'],
					"field_189" => $frmData['field_189'],
					"field_190" => $frmData['field_190'],
					"field_191" => $frmData['field_191'],
					"field_192" => $frmData['field_192'],
					"field_193" => $frmData['field_193'],
					"field_194" => $frmData['field_194'],
					"field_195" => $frmData['field_195'],
					"field_196" => $frmData['field_196'],
					"field_197" => $frmData['field_197'],
					"field_198" => $frmData['field_198'],
					"field_199" => $frmData['field_199'],
					"field_200" => $frmData['field_200'],
					"field_201" => $frmData['field_201']
            ); //echo '<pre>';print_r($insertData);exit;

            if ($this->db->insert("consumer_selection_criteria", $insertData)) {
				
				
                $this->session->set_flashdata('success', 'Consumer Selection Criteria Added Successfully!');
                return 1;
            }
            return 0;
        }
    }
	
    

    function get_total_consumer_selection_criterias_all($srch_string = '') {
        $result_data = 0;
        $user_id = $this->session->userdata('admin_user_id');
        
        if (!empty($srch_string)) {
            $this->db->where("(unique_system_selection_criteria_id LIKE '%$srch_string%' OR name_of_selection_criteria LIKE '%$srch_string%') and (customer_id=$user_id)");
        } else {
            if (empty($user_id)) {
                $user_id = 1;
            }
            $this->db->where(array('customer_id' => $user_id));
        }

        $this->db->select('count(1) as total_rows');
        $this->db->from('consumer_selection_criteria');
        $query = $this->db->get(); //echo '***'.$this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $result_data = $result[0]['total_rows'];
        }
        return $result_data;
    }
    function get_list_consumer_selection_criterias_all($limit,$start,$srch_string = '') {
        $result_data = 0;
        $user_id = $this->session->userdata('admin_user_id');
        
        if (!empty($srch_string)) {
            $this->db->where("(unique_system_selection_criteria_id LIKE '%$srch_string%' OR name_of_selection_criteria LIKE '%$srch_string%') and (customer_id=$user_id)");
        } else {
            if (empty($user_id)) {
                $user_id = 1;
            }
            $this->db->where(array('customer_id' => $user_id));
        }

        $this->db->select('*');
        $this->db->from('consumer_selection_criteria');
        $this->db->order_by('criteria_id', 'desc');
        if (empty($srch_string)) {
            $this->db->limit($limit, $start);
        }
        //echo $this->db->last_query();die;
        $query = $this->db->get(); //echo '***'.$this->db->last_query();
        if ($query->num_rows() > 0) {
            $result_data = $query->result_array();
        }
        return $result_data;
    }


    function get_consumer_selection_criteria_details($id) {

        $this->db->select('*');
        $this->db->from('consumer_selection_criteria');
       // $this->db->join('assign_locations_to_users AS ap', 'ap.user_id = bu.user_id','LEFT');
        $this->db->where(array('unique_system_selection_criteria_id' => $id));
        $query = $this->db->get();
        // echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            //$res = $res[0];
        }
        return $res;
    }
	
	
	    function checkPromotionType($promotion_type, $user_id, $uid = '') {
        $result = 'true';
        if ($this->input->post('register_username') != '') {
            $uname = $this->input->post('register_username');
        }
        $this->db->select('criteria_id');
        $this->db->from('consumer_selection_criteria');
        if (!empty($uid)) {
            $this->db->where(array('criteria_id!=' => $uid));
        }
        $this->db->where(array('promotion_type' => $promotion_type, 'customer_id' => $user_id));
        $query = $this->db->get();
        //echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            $result = $res[0]['criteria_id'];
            $result = 'false';
        }
        return $result;
    }
	
	
		// consumer profile master 
	    function get_total_consumer_profile_attributes_all($srch_string = '') {
        $result_data = 0;
        $user_id = $this->session->userdata('admin_user_id');
        
        if (!empty($srch_string)) {
            $this->db->where("(cpm_type_name LIKE '%$srch_string%' OR cpm_name LIKE '%$srch_string%') and (created_by_id=$user_id)");
        } else {
            if (empty($user_id)) {
                $user_id = 1;
            }
            $this->db->where(array('created_by_id' => $user_id));
        }

        $this->db->select('count(1) as total_rows');
        $this->db->from('consumer_profile_master');
        $query = $this->db->get(); //echo '***'.$this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $result_data = $result[0]['total_rows'];
        }
        return $result_data;
    }
    function get_list_consumer_profile_attributes_all($limit,$start,$srch_string = '') {
        $result_data = 0;
        $user_id = $this->session->userdata('admin_user_id');
        
        if (!empty($srch_string)) {
            $this->db->where("(cpm_type_name LIKE '%$srch_string%' OR cpm_name LIKE '%$srch_string%') and (created_by_id=$user_id)");
        } else {
            if (empty($user_id)) {
                $user_id = 1;
            }
            $this->db->where(array('created_by_id' => $user_id));
        }

        $this->db->select('*');
        $this->db->from('consumer_profile_master');
        $this->db->order_by('cpm_id', 'desc');
        if (empty($srch_string)) {
            $this->db->limit($limit, $start);
        }
        //echo $this->db->last_query();die;
        $query = $this->db->get(); //echo '***'.$this->db->last_query();
        if ($query->num_rows() > 0) {
            $result_data = $query->result_array();
        }
        return $result_data;
    }
	
	
	
	
 function checkProfileAttribute($Profile_Attribute, $user_id, $cpm_type_slug) {
        $result = 'true';
		/*
        if ($this->input->post('register_username') != '') {
            $uname = $this->input->post('register_username');
        }
		*/
		$cpm_type_slug1 = getAttributeSlugByName($Profile_Attribute);
        $this->db->select('cpm_name, cpm_type_slug');
        $this->db->from('consumer_profile_master');
		/*
        if (!empty($cpmid)) {
            $this->db->where(array('cpm_id!=' => $cpmid));
        }*/
        $this->db->where(array('cpm_name' => $Profile_Attribute, 'cpm_type_slug' => $cpm_type_slug1));
        $query = $this->db->get();
        //echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            $result = $res[0]['cpm_name'];
            $result = 'false';
        }
        return $result;
    }
	

	function save_consumer_profile_attributes($frmData) {   
        $user_id = $this->session->userdata('admin_user_id'); 
		
				$arr1 = explode('-',trim($frmData['attribute_type_slug']));
				$attribute_type_slug = $arr1[0];
				$profile_bucket = $arr1[1];
				
			
        if (!empty($frmData['cpm_id'])) {           
                $UpdateData = array(
					"cpm_type_slug" => $attribute_type_slug,
                    "cpm_type_name" => getAttributeTypeNameBySlug($attribute_type_slug),
                    "cpm_name" => $frmData['attribute_name'],	
					"cpm_slug" => $frmData['cpm_slug'],
					"profile_bucket" => $profile_bucket,
					"created_by_id" => $user_id,
					"modify_date" => date('Y-m-d H:i:s'),
                    "status" => 1                    
                );
            //$this->db->insert("assign_plants_to_users", $insertData);
            $whereData = array(
                'cpm_id' => $frmData['cpm_id']
            );

            $this->db->set($UpdateData);
            $this->db->where($whereData);
            if ($this->db->update('consumer_profile_master')) {
                //echo '***'.$this->db->last_query();exit;
                $this->session->set_flashdata('success', 'Consumer Profile Attribute Updated Successfully!');
                return 1;
            }
        } else {            
            $insertData = array(
					//"customer_id " => $user_id,
					"cpm_type_slug" => $attribute_type_slug,
                    "cpm_type_name" => getAttributeTypeNameBySlug($attribute_type_slug),
                    "cpm_name" => $frmData['attribute_name'],	
					"cpm_slug" => $frmData['cpm_slug'],
					"profile_bucket" => $profile_bucket,	
					"created_by_id" => $user_id,
					"create_date" => date('Y-m-d H:i:s'),
                    "status" => 1
            ); //echo '<pre>';print_r($insertData);exit;
            if ($this->db->insert("consumer_profile_master", $insertData)) {
                $this->session->set_flashdata('success', 'Consumer Profile Attribute Added Successfully!');
                return 1;
            }
            return 0;
        }
    }
	
	
	    function get_consumer_profile_attribute_details($id) {
        $this->db->select('*');
        $this->db->from('consumer_profile_master');
       // $this->db->join('assign_locations_to_users AS ap', 'ap.user_id = bu.user_id','LEFT');
        $this->db->where(array('cpm_id' => $id));
        $query = $this->db->get();
        // echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            //$res = $res[0];
        }
        return $res;
    }
	
	    function Del_Attribute($id) {
        $this->db->where('cpm_id', $id);
        if ($this->db->delete('consumer_profile_master')) {
            return '1';
        }
    }
	
	
	// end consumer profile master 
	
	
	// Consumer Profile Attribute Type Master Work Start
	    function get_total_consumer_profile_attribute_types_all($srch_string = '') {
        $result_data = 0;
        $user_id = $this->session->userdata('admin_user_id');
        
        if (!empty($srch_string)) {
            $this->db->where("(cpatm_name LIKE '%$srch_string%') and (created_by_id=$user_id)");
        } else {
            if (empty($user_id)) {
                $user_id = 1;
            }
            $this->db->where(array('created_by_id' => $user_id));
        }

        $this->db->select('count(1) as total_rows');
        $this->db->from('consumer_profile_attribute_type_master');
        $query = $this->db->get(); //echo '***'.$this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $result_data = $result[0]['total_rows'];
        }
        return $result_data;
    }
    function get_list_consumer_profile_attribute_types_all($limit,$start,$srch_string = '') {
        $result_data = 0;
        $user_id = $this->session->userdata('admin_user_id');
        
        if (!empty($srch_string)) {
            $this->db->where("(cpatm_name LIKE '%$srch_string%') and (created_by_id=$user_id)");
        } else {
            if (empty($user_id)) {
                $user_id = 1;
            }
            $this->db->where(array('created_by_id' => $user_id));
        }

        $this->db->select('*');
        $this->db->from('consumer_profile_attribute_type_master');
        $this->db->order_by('cpatm_id', 'asc');
        if (empty($srch_string)) {
            $this->db->limit($limit, $start);
        }
        //echo $this->db->last_query();die;
        $query = $this->db->get(); //echo '***'.$this->db->last_query();
        if ($query->num_rows() > 0) {
            $result_data = $query->result_array();
        }
        return $result_data;
    }
	
	
	
	
 function checkProfileAttributeType($Profile_AttributeType, $user_id, $cpatmid = '') {
        $result = 'true';
        if ($this->input->post('register_username') != '') {
            $uname = $this->input->post('register_username');
        }
        $this->db->select('cpatm_id');
        $this->db->from('consumer_profile_attribute_type_master');
		/*
        if (!empty($cpatmid)) {
            $this->db->where(array('cpatm_id!=' => $cpatmid));
        }
		*/
        $this->db->where(array('cpatm_name' => $Profile_AttributeType));
        $query = $this->db->get();
        //echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 1) {
            $res = $query->result_array();
            $result = $res[0]['cpatm_id'];
            $result = 'false';
        }
        return $result;
    }
	

	function save_consumer_profile_attribute_types($frmData) {   
        $user_id = $this->session->userdata('admin_user_id');        
        if (!empty($frmData['cpatm_id'])) {           
                $UpdateData = array(
                    "cpatm_name" => $frmData['cpatm_name'],	
					"profile_bucket" => $frmData['profile_bucket'],
					"created_by_id" => $user_id,
					"modify_date" => date('Y-m-d H:i:s'),
                    "status" => 1                    
                );
            $whereData = array(
                'cpatm_id' => $frmData['cpatm_id']
            );

            $this->db->set($UpdateData);
            $this->db->where($whereData);
            if ($this->db->update('consumer_profile_attribute_type_master')) {
                //echo '***'.$this->db->last_query();exit;
                $this->session->set_flashdata('success', 'Consumer Profile Attribute Type Updated Successfully!');
                return 1;
            }
        } else {            
            $insertData = array(
                    "cpatm_name" => $frmData['cpatm_name'],	
					"profile_bucket" => $frmData['profile_bucket'],					
					"created_by_id" => $user_id,
					"create_date" => date('Y-m-d H:i:s'),
                    "status" => 1
            ); //echo '<pre>';print_r($insertData);exit;
            if ($this->db->insert("consumer_profile_attribute_type_master", $insertData)) {
                $this->session->set_flashdata('success', 'Consumer Profile Attribute Type Added Successfully!');
                return 1;
            }
            return 0;
        }
    }
	
	
	    function get_consumer_profile_attribute_type_details($id) {
        $this->db->select('*');
        $this->db->from('consumer_profile_attribute_type_master');
       // $this->db->join('assign_locations_to_users AS ap', 'ap.user_id = bu.user_id','LEFT');
        $this->db->where(array('cpatm_id' => $id));
        $query = $this->db->get();
        // echo '***'.$this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
            //$res = $res[0];
        }
        return $res;
    }
	
	    function Del_AttributeType($id) {
        $this->db->where('cpatm_id', $id);
        if ($this->db->delete('consumer_profile_attribute_type_master')) {
            return '1';
        }
    }
	
	
	// Consumer Profile Attribute Type Master Work end

	
	// save_number_of_consumers_selected
	    function save_number_of_consumers_selected($frmData) {   
        $user_id = $this->session->userdata('admin_user_id');
        
        if (!empty($frmData['unique_system_selection_criteria_id'])) {
           
                $UpdateData = array(
                   "number_of_consumers_selected" => $frmData['number_of_consumers_selected']                  
                );
            
            //$this->db->insert("assign_plants_to_users", $insertData);
            $whereData = array(
                'unique_system_selection_criteria_id' => $frmData['unique_system_selection_criteria_id']
            );

            $this->db->set($UpdateData);
            $this->db->where($whereData);
            if ($this->db->update('consumer_selection_criteria')) {
                //echo '***'.$this->db->last_query();exit;
                $this->session->set_flashdata('success', 'Number of Consumers Selected Updated Successfully!');
                return 1;
            }
        } else {
            
            $insertData = array(
					"number_of_consumers_selected" => $frmData['number_of_consumers_selected']

            ); //echo '<pre>';print_r($insertData);exit;

            if ($this->db->insert("consumer_selection_criteria", $insertData)) {
				
				
                $this->session->set_flashdata('success', 'Number of Consumers Selected Updated Successfully!');
                return 1;
            }
            return 0;
        }
    }
	
	// FAQ Master Start
	
		    function get_total_faqs_master_all($srch_string = '') {
        $result_data = 0;
        $user_id = $this->session->userdata('admin_user_id');
        
        if (!empty($srch_string)) {
            $this->db->where("(faq_type LIKE '%$srch_string%' OR faq_question LIKE '%$srch_string%' OR faq_answer LIKE '%$srch_string%') and (created_by_id=$user_id)");
        } else {
            if (empty($user_id)) {
                $user_id = 1;
            }
            $this->db->where(array('created_by_id' => $user_id));
        }

        $this->db->select('count(1) as total_rows');
        $this->db->from('faq_master');
        $query = $this->db->get(); //echo '***'.$this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $result_data = $result[0]['total_rows'];
        }
        return $result_data;
    }
    function get_list_faqs_master_all($limit,$start,$srch_string = '') {
        $result_data = 0;
        $user_id = $this->session->userdata('admin_user_id');
        
        if (!empty($srch_string)) {
             $this->db->where("(faq_type LIKE '%$srch_string%' OR faq_question LIKE '%$srch_string%' OR faq_answer LIKE '%$srch_string%') and (created_by_id=$user_id)");
        } else {
            if (empty($user_id)) {
                $user_id = 1;
            }
            $this->db->where(array('created_by_id' => $user_id));
        }

        $this->db->select('*');
        $this->db->from('faq_master');
       // $this->db->order_by('faq_id', 'desc');
        if (empty($srch_string)) {
            $this->db->limit($limit, $start);
        }
        //echo $this->db->last_query();die;
        $query = $this->db->get(); //echo '***'.$this->db->last_query();
        if ($query->num_rows() > 0) {
            $result_data = $query->result_array();
        }
        return $result_data;
    }
	
	
	    function checkFAQs($faq_question) {
            $result = 'true';
    		
    		//$cpm_type_slug1 = getAttributeSlugByName($Profile_Attribute);
            $this->db->select('faq_question');
            $this->db->from('faq_master');
    		/*
            if (!empty($cpmid)) {
                $this->db->where(array('cpm_id!=' => $cpmid));
            }*/
            $this->db->where(array('faq_question' => $faq_question));
            $query = $this->db->get();
            //echo '***'.$this->db->last_query();exit;
            if ($query->num_rows() > 0) {
                $res = $query->result_array();
                $result = $res[0]['faq_question'];
                $result = 'false';
            }
            return $result;
        }
    	
    
    	function save_faqs_master($frmData) {   
            $user_id = $this->session->userdata('admin_user_id'); 
    		
    				//$arr1 = explode('-',trim($frmData['attribute_type_slug']));
    				//$attribute_type_slug = $arr1[0];
    				//$profile_bucket = $arr1[1];
    				
    			
            if (!empty($frmData['faq_id'])) {           
                    $UpdateData = array(
    					"faq_type" => $frmData['faq_type'],
                        "faq_question" => $frmData['faq_question'],
                        "faq_answer" => $frmData['faq_answer'],	
    					"updated_by_id" => $user_id,
    					"update_date" => date('Y-m-d H:i:s'),
                        "status" => 1                    
                    );
                //$this->db->insert("assign_plants_to_users", $insertData);
                $whereData = array(
                    'faq_id' => $frmData['faq_id']
                );
    
                $this->db->set($UpdateData);
                $this->db->where($whereData);
                if ($this->db->update('faq_master')) {
                    //echo '***'.$this->db->last_query();exit;
                    $this->session->set_flashdata('success', 'Record Updated Successfully!');
                    return 1;
                }
            } else {            
                $insertData = array(
    					//"customer_id " => $user_id,
    					"faq_type" => $frmData['faq_type'],
                        "faq_question" => $frmData['faq_question'],
                        "faq_answer" => $frmData['faq_answer'],	
    					"created_by_id" => $user_id,
    					"create_date" => date('Y-m-d H:i:s'),
                        "status" => 1
                ); //echo '<pre>';print_r($insertData);exit;
                if ($this->db->insert("faq_master", $insertData)) {
                    $this->session->set_flashdata('success', 'Record Added Successfully!');
                    return 1;
                }
                return 0;
            }
        }
    	
    	
    	    function get_faqs_master_details($id) {
            $this->db->select('*');
            $this->db->from('faq_master');
           // $this->db->join('assign_locations_to_users AS ap', 'ap.user_id = bu.user_id','LEFT');
            $this->db->where(array('faq_id' => $id));
            $query = $this->db->get();
            // echo '***'.$this->db->last_query();exit;
            if ($query->num_rows() > 0) {
                $res = $query->result_array();
                //$res = $res[0];
            }
            return $res;
			}
    	
    	    function Del_FAQs($id) {
            $this->db->where('faq_id', $id);
            if ($this->db->delete('faq_master')) {
                return '1';
				}
			}
	
// FAQ Master Start

}

