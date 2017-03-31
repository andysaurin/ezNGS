<?php

class projects_users extends NQ_Auth_User
{
    public function __construct()
    {
        parent::__construct();

        $this->class_title = "Projects - Users Panel";
        $this->all_projects = $this->all_projects();

        foreach($this->all_projects as $k => $project) {

            $users = $this->project_users($project->id);

            $this->all_projects[$k]->users = $users;
            $this->all_projects[$k]->available_users = $this->all_users($users);

        }

        $this->set("all_users", $this->all_users($users) );

        //We need to know if current user are manager of some projects or not
        //Strategy create an array where you find name's project manage by current user
        //if this one is never manager create an empty array
        $manager = array();

        foreach($this->all_projects as $k => $project) {
            if($this->is_project_manager( $this->user->id,$project->id)){
                $manager[] = $project->name;
                }
            }

        $this->set("manager",  $manager );
        $this->set('projects',  $this->all_projects );
        $this->set("is_rna_ok", false);
    }

    public function __default()
    {
        if (!empty($_POST)) {//check if this array is empty.
            //echo $_POST['group_id'];
            if (!$this->delete_group_already_define($_POST['group_id'],$_POST['project_id'] )){

            }
        }
        //$this->set('projects',  $this->all_projects );

        //Test about project additional info
        //print_r($this->get_additional_projects_info());

        $this->set('info_projects_available', $this->get_additional_projects_info());
    }

    public function delete_pair()
    {
        if (!empty($_POST)) {//check if this array is empty.
            if (!$this->delete_chip_pair_already_define($_POST["md5sum_treated_sample"],$_POST["md5sum_input_sample"],$_POST['project_id'])){
                die("Fatal toto!");
            }
        }

    }

	public function save_samples()
	{

		$num_samples_treated = 0;

		if (!empty($_POST) && is_array($_POST['sample'] ) && isset($_POST['form_submit']) ){

			$project_id = (int)$_POST['project_id'];


			foreach( $_POST['sample'] as $sample ) {

				unset($sample_id); //prevent previous iteractions from interfering

				//we only save samples that have a name, a type and at least one file
				//unless the sample_id value is already set
				if ( (int)$sample['sample_id'] > 0 ||
							( $sample['sample_name'] && (int)$sample['sample_type'] > 0  &&
								( (int)$sample['file_1_id'] > 0 || (int)$sample['file_2_id'] > 0 )
							)
					) {

					if ( is_numeric($sample['sample_id']) && $sample['sample_id'] > 0 ) {

						$sample_id = (int)$sample['sample_id'];

					}
					$sample_name = mysql_real_escape_string( trim($sample['sample_name']) );
					$sample_type = (int)$sample['sample_type'];
					$file_1_id = (int)$sample['file_1_id'];
					$file_2_id = (int)$sample['file_2_id'];


					//if we only chose one file then make sure it is file_1_id
					if ( $file_2_id > 0 && $file_1_id == 0 ) {

						$file_1_id = $file_2_id;
						$file_2_id = 0;

					}

					if ( is_numeric($sample_id) && $sample_id > 0 ) { //we already have this sample stored, so let's swap the db values with these ones in case we changed anything

						//is this sample_id actually assigned to this project? If not, we cannot alter it!
						if ( $this->db->get_var("SELECT `project_id` FROM `samples_projects` WHERE `sample_id`={$sample_id} && `project_id`={$project_id} LIMIT 1 ") ==  $project_id ) {

							//ok, sample is assigned to this project, so all checks out - let's edit it

							if ( $file_1_id < 1 && $file_2_id < 1 ) { // we have unassigned all files from the sample, so let's delete the sample

								$query = "DELETE FROM `samples` WHERE `sample_id`={$sample_id} LIMIT 1";

								$this->db->query($query);

								if ( $this->db->rows_affected > 0 ) {
									$query = "DELETE FROM `samples_projects` WHERE `sample_id`={$sample_id} AND `project_id`={$project_id} LIMIT 1";
									$this->db->query($query);

									if ( $this->db->rows_affected > 0 ) {
										$num_samples_treated++;
									}

								}

							} else {

								$query = "REPLACE INTO `samples` SET `sample_id`={$sample_id}, `sample_name`='{$sample_name}', `sample_type`={$sample_type}, `file_1_id`={$file_1_id}, `file_2_id`={$file_2_id} ";

								$this->db->query($query);

								if ( $this->db->rows_affected > 0 ) {
									$num_samples_treated++;
								}

							}

						}


					} else { //new entry

						$query = "INSERT INTO `samples` SET `sample_name`='{$sample_name}', `sample_type`={$sample_type}, `file_1_id`={$file_1_id}, `file_2_id`={$file_2_id} ";

						$this->db->query($query);

						//what was the inserted sample_id
						$sample_id = $this->db->insert_id;

						if ( $sample_id > 0 ) {
							//map sample_id to project_id
							$query = "INSERT INTO `samples_projects` SET `sample_id`={$sample_id}, `project_id`={$project_id}";

							$this->db->query($query);

							if ( $this->db->rows_affected > 0 ) {
								$num_samples_treated++;
							}

						}
					}

				}

			}

			if ($num_samples_treated > 0) {
				if ( $num_samples_treated == 1 )
					$message['text'] = "{$num_samples_treated} sample has been saved/modified";
				else
					$message['text'] = "{$num_samples_treated} samples have been saved/modified";
				$message['type'] = 'success';
				$message['delay'] = '3000';

				$this->session->message = $message;

			} else  {

				$message['text'] = "No samples were modified or created";
				$message['type'] = 'warning';
				$message['delay'] = '3000';

				$this->session->message = $message;

			}


		}

       header("Location: go/?id={$project_id}&active=sampleAttribution" );
	   exit;

	}

    public function rna_define_groups()
    {
        if (!empty($_POST)){//check if the array are empty
            $data_type = 2;
            //we need the project_id so we save it and delete it in the array
            $project_id=$_POST['project_id'];
            array_shift($_POST);
            //in the html table foreach sub array the first line is empty and is used like a "template"
            //so we delete these lines before to save all information in the DB
            array_shift($_POST["Group_name"]);
            array_shift($_POST["Group_description"]);
            if (!$this->groups_in_db($_POST, $project_id,$data_type)){
                die("Error saving RNA group");
            }
        }
    }

    public function ChIP_define_groups()
    {
        if (!empty($_POST)){//check if the array are empty
            $data_type = 1;
            //we need the project_id so we save it and delete it in the array
            $project_id=$_POST['project_id'];
            array_shift($_POST);
            //in the html table foreach sub array the first line is empty and is used like a "template"
            //so we delete these lines before to save all information in the DB
            array_shift($_POST["Group_name"]);
            array_shift($_POST["Group_description"]);
            if (!$this->groups_in_db($_POST, $project_id,$data_type)){
                die("Error saving ChIP group");
            }
        }
    }

    public function save_chip_design()
    {
        if (!empty($_POST)) {//check if this array is empty.
            $project_id=$_POST['project_id'];
            unset($_POST['project_id']);
            //print_r($_POST);
            //print_r($this->write_chip_design($_POST, $project_id));
            if (!$this->write_chip_design($_POST, $project_id)){
                die("Error saving ChIP design.tab");
            }
        }
    }

    public function save_design()
    {
        if (!empty($_POST)) {//check if this array is empty.
            //print_r($_POST);
            //in the html table foreach sub array the first line is empty and is used like a "template"
            //so we delete these lines before to save all information in the DB
            $project_id=$_POST['project_id'];
            unset($_POST['project_id']);
            //array_shift($_POST["Group_name_available"]);
            array_shift($_POST["Group_reference"]);
            array_shift($_POST["Group_test"]);

            if (!$this->write_rna_design($_POST, $project_id)){
                die("Error saving RNA design.tab");
            }

        }
    }

    /* 11/10/2016 public function delete_rna_group_already_define()
    {
        if (!empty($_POST)) {//check if this array is empty.
            echo $_POST['group_id'];
            if (!$this->delete_rna_group_already_define($_POST['group_id'],$_POST['project_id'] )){
                die("Error De la muerta");
            }
        }
    }*/

    public function write_sample_rna()
    {
        if (!empty($_POST)) {//check if this array is empty.
            $project_id=$_POST['project_id'];
            unset($_POST['project_id']);
            array_shift($_POST);
            //print_r($_POST);

            if (!$this->Write_tab_file_rna($_POST,$project_id)){
                die("Error saving RNA samples.tab");
            }

        }
    }

    public function write_sample_chip()
    {
        if (!empty($_POST)) {//check if this array is empty.
            $project_id=$_POST['project_id'];
            unset($_POST['project_id']);
            array_shift($_POST);
            //print_r($_POST);

            if (!$this->Write_tab_file_chip($_POST,$project_id)){
                die("Error saving ChIP samples.tab");
            }

        }
    }


    public function save_rna_assignation()
    {
        //print_r($_POST);
        /* 18/09/2016 for($sample = 1; $sample < count($_POST["rna_groups_assignation"]["md5sum"]); $sample++) {
            $md5 = $_POST["rna_groups_assignation"]["md5sum"][$sample];
            $Sample_name = $_POST["rna_groups_assignation"]["Sample_name"][$sample];
            $groups = "";
            foreach ($_POST["rna_groups_assignation"][$md5] as $group => $groupName) {
                $groups = $groups . $groupName . ", ";
            }
            echo "MD5sum: ". $md5 . "Sample_name: " . $Sample_name . "Group: " . $groups;
        }*/

        if (!empty($_POST)) {//check if this array is empty.
            $project_id = $_POST['project_id'];
            array_shift($_POST);
            if (!$this->add_rna_assignation_in_db($_POST, $project_id)){
                die("Error saving RNA assignation");
            }

        }


    }

    public function save_chip_assignation()
    {
        //print_r($_POST);
//        /* 18/09/2016 for($sample = 1; $sample < count($_POST["rna_groups_assignation"]["md5sum"]); $sample++) {
//            $md5 = $_POST["rna_groups_assignation"]["md5sum"][$sample];
//            $Sample_name = $_POST["rna_groups_assignation"]["Sample_name"][$sample];
//            $groups = "";
//            foreach ($_POST["rna_groups_assignation"][$md5] as $group => $groupName) {
//                $groups = $groups . $groupName . ", ";
//            }
//            echo "MD5sum: ". $md5 . "Sample_name: " . $Sample_name . "Group: " . $groups;
//        }*/
//
        if (!empty($_POST)) {//check if this array is empty.
            $project_id = $_POST['project_id'];
            array_shift($_POST);//delete file_id array
            //print_r($_POST);
            //print_r($this->add_chip_assignation_in_db($_POST, $project_id));
            if (!$this->add_chip_assignation_in_db($_POST, $project_id)){
                die("Error saving chip assignation");
            }

        }


    }

    public function save_chip_sample_type()
    {//we store if the sample are treated or an input genomic

        if (!empty($_POST)) {//check if this array is empty.
            //print_r($_POST);
            $project_id = $_POST['project_id'];
            array_shift($_POST);
            if (!$this->add_chip_sample_type_in_db($_POST, $project_id)){
                die("Error saving chip sample_type");
            }
            //print_r($this->add_chip_sample_type_in_db($_POST, $project_id));

        }


    }

    public function save_chip_sample_pair()
    {
        //En construction
        if (!empty($_POST)) {//check if this array is empty.
            //print_r($_POST);
            $project_id = $_POST['project_id'];
            array_shift($_POST);//Delete the project_id
            array_shift($_POST);//delete the template line
            //print_r($_POST);
            //print_r($this->add_chip_sample_pair_in_db($_POST, $project_id));

            if (!$this->add_chip_sample_pair_in_db($_POST, $project_id)){
                die("Error saving chip sample pair");
            }

            //print_r($this->add_chip_sample_type_in_db($_POST, $project_id));

        }
    }

    public function save_annotations()
    {

		$project_id = $_POST['project_id'];

        if (!empty($_POST)){//check if this array is empty.
            //We store the location of the YAML file
            $filename = SYSTEM_PROJECTS_ROOT . "/" . $_POST['project_id'] . "/metadata/" . "/description.yml";
            //array_shift($_POST);

            /*First step fill the metadata table, so need to obtain all column name*/
            $all_col_name_array = array_keys($_POST["Samples_information"]);
            if (!$this->metadata_in_db($all_col_name_array, $_POST['project_id'])){
                die("Error saving metadata header");
            }
            if (!$this->metadata_value_in_db($_POST["Samples_information"])){
                die("Error saving metadata value");
            }

            array_shift($_POST);
            $res = yaml_emit_file($filename, $_POST, $encoding = YAML_UTF8_ENCODING );
        }


		$message['text'] = 'Changes to the annotations have been made';
		$message['type'] = 'success';
		$message['delay'] = '3000';

		$this->session->message = $message;

       header("Location: go/?id={$project_id}&active=sampleAnnotation" );
	   exit;
    }

    public function save_rna_config()
    {
        if (!empty($_POST)) {//check if this array is empty.
            $pathToProject = SYSTEM_PROJECTS_ROOT . "/" . $_POST['project_id'];
            $filenameYaml = SYSTEM_PROJECTS_ROOT . "/" . $_POST['project_id'] . "/metadata/RNA" . "/config.yml";
            #$filenameJson = SYSTEM_PROJECTS_ROOT . "/" . $_POST['project_id'] . "/metadata" . "/config.json";
            //$temp = SYSTEM_PROJECTS_ROOT . "/" . $_POST['project_id'] . "/metadata" . "/configtemp.yml";
            $configinit = yaml_parse_file($filenameYaml);
            //print_r($configinit);

            /*Part about some parameters set by the server*/
            $_POST["author"] = $this->user->username;
            $_POST["qsub"]="-q biotools -V -m a -d . ";
            $_POST["metadata"]["samples"] = $pathToProject . "/metadata/RNA/samples.tab";
            $_POST["metadata"]["design"] = $pathToProject . "/metadata/RNA/design.tab";
            $_POST["metadata"]["configfile"] = $pathToProject . "/metadata/RNA/config.yml";

            $_POST["dir"]["base"] = $pathToProject;
            $_POST["dir"]["reads_source"] = $pathToProject . "/samples";
            $_POST["dir"]["fastq"] = $pathToProject . "/samples";
            $_POST["dir"]["genome"] = SYSTEM_DATA_ROOT .  "/genomes/Ecoli_K12"; //WARNING HARD CODE to chage after test !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            $_POST["dir"]["results"] = $pathToProject . "/results/RNA";
            $_POST["dir"]["gene_regulation"] = $pathToProject . "/gene-regulation";

            $_POST["dir"]["samples"] = $pathToProject . "/results/RNA/samples";
            $_POST["dir"]["diffexpr"] = $pathToProject . "/results/RNA/diffexpr";
            $_POST["dir"]["reports"] = $pathToProject . "/results/RNA/reports";

            //echo implode(" ",$_POST["Mapping"]);

            /*if (isset($_POST["Mapping"])){
                $configinit["tools"]["mapping"]=implode(" ",$_POST["Mapping"]);
                unset($_POST["Mapping"]);
            }*/

            $filenameToolsAvailable = SYSTEM_CONFIG_TOOLS_DIR . "tools_available.yml";
            $configToolsAvailable = yaml_parse_file($filenameToolsAvailable);
            $stepsOfAnalysis = array_keys($configToolsAvailable["RNA-seq"]);

            foreach ($_POST as $key => $value){
                if (is_array($value)){
                    //echo $value;
                    foreach ($value as $key2 => $item) {
//                        if (isset($_POST["Mapping"])){
                        //if ($key == "Mapping"){
                        if (in_array($key,$stepsOfAnalysis)){
                            $stepName = strtolower($key);
                            //echo $value;
                            //echo $_POST[$key];
                            //echo $key;
                            $configinit["tools"]["$stepName"]=implode(" ",$_POST[$key]);
                            //unset($key);
                        }else{
                            $configinit[$key][$key2]=trim($item);
                        }
                    }
                }else{
                    $configinit[$key]=trim($value);
                }
            }

            //We need to define for the Diffexpr step the condRef in the config file
            $designFile = SYSTEM_PROJECTS_ROOT . "/" . $_POST['project_id'] . "/metadata/RNA" . "/design.tab";
            $fh = fopen($designFile, 'r');
            $i = 0;
            $cols = array();
            $condRef = "";

            while (($line = fgetcsv($fh,0,"\t")) !== false) {
                $cols[] = $line;

                if($i == 1)
                {   $condRef = $line[0];
                    break;
                }
                $i++;
            }
            //print_r($_POST["diffexpr"]);
            foreach ($_POST["diffexpr"] as $tool) {
                $configinit[$tool]["condRef"]=$condRef;
            }


            //Write the config file
            $res = yaml_emit_file($filenameYaml, $configinit);
        }
    }

    public function save_chip_config()
    {
        if (!empty($_POST)) {//check if this array is empty.
            $pathToProject = SYSTEM_PROJECTS_ROOT . "/" . $_POST['project_id'];
            $filenameYaml = SYSTEM_PROJECTS_ROOT . "/" . $_POST['project_id'] . "/metadata/ChIP" . "/config.yml";
            #$filenameJson = SYSTEM_PROJECTS_ROOT . "/" . $_POST['project_id'] . "/metadata" . "/config.json";
            //$temp = SYSTEM_PROJECTS_ROOT . "/" . $_POST['project_id'] . "/metadata" . "/configtemp.yml";
            $configinit = yaml_parse_file($filenameYaml);
            //print_r($configinit);

            /*Part about some parameters set by the server*/
            $_POST["author"] = $this->user->username;
            $_POST["qsub"]="-q biotools -V -m a -d . ";
            $_POST["metadata"]["samples"] = $pathToProject . "/metadata/ChIP/samples.tab";
            $_POST["metadata"]["design"] = $pathToProject . "/metadata/ChIP/design.tab";
            $_POST["metadata"]["configfile"] = $pathToProject . "/metadata/ChIP/config.yml";

            $_POST["dir"]["base"] = $pathToProject;
            $_POST["dir"]["reads_source"] = $pathToProject . "/samples";
            $_POST["dir"]["fastq"] = $pathToProject . "/samples";
            $_POST["dir"]["genome"] = SYSTEM_DATA_ROOT .  "/genomes/Ecoli_K12"; //WARNING HARD CODE to chage after test !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            $_POST["dir"]["results"] = $pathToProject . "/results/ChIP";
            $_POST["dir"]["gene_regulation"] = $pathToProject . "/gene-regulation";

            $_POST["dir"]["samples"] = $pathToProject . "/results/ChIP/samples";
            $_POST["dir"]["peaks"] = $pathToProject . "/results/ChIP/peaks";
            $_POST["dir"]["reports"] = $pathToProject . "/results/ChIP/reports";

            $filenameToolsAvailable = SYSTEM_CONFIG_TOOLS_DIR . "tools_available.yml";
            $configToolsAvailable = yaml_parse_file($filenameToolsAvailable);
            $stepsOfAnalysis = array_keys($configToolsAvailable["ChIP-seq"]);

            foreach ($_POST as $key => $value){
                if (is_array($value)){
                    //echo $value;
                    foreach ($value as $key2 => $item) {
//                        if (isset($_POST["Mapping"])){
                        //if ($key == "Mapping"){
                        if (in_array($key,$stepsOfAnalysis)){
                            $stepName = strtolower($key);
                            //echo $value;
                            //echo $_POST[$key];
                            //echo $key;
                            $configinit["tools"]["$stepName"]=implode(" ",$_POST[$key]);
                            //unset($key);
                        }else{
                            $configinit[$key][$key2]=trim($item);
                        }
                    }
                }else{
                    $configinit[$key]=trim($value);
                }
            }


            //Write the config file
            $res = yaml_emit_file($filenameYaml, $configinit);
        }
    }



    public function execute_rna_workflow_default()
    {
        if (!empty($_POST)) {//check if this array is empty.
            //define the path
            $pathToProject = SYSTEM_PROJECTS_ROOT . "/" . $_POST['project_id'];
            //echo $pathToProject;

            //we need to touch all the data files before to run the analysis
            $pathToSamples = $pathToProject . "/samples";
            `find "{$pathToSamples}" -exec touch {} \;`;

            //Run the analysis with the workflow
            $cmd = '/usr/bin/snakemake -s ' . SYSTEM_DATA_ROOT . '/workflows/RNA-seq_workflow_SE.py -j 8 --configfile ' . $pathToProject . '/metadata/RNA/config.yml 2>' . $pathToProject . '/RNA_stdout.txt';
            shell_exec($cmd);
            //echo $cmd;
        }
    }

    public function execute_chip_workflow_default()
    {
        if (!empty($_POST)) {//check if this array is empty.
            //define the path
            $pathToProject = SYSTEM_PROJECTS_ROOT . "/" . $_POST['project_id'];
            //echo $pathToProject;

            //we need to touch all the data files before to run the analysis
            $pathToSamples = $pathToProject . "/samples";
            `find "{$pathToSamples}" -exec touch {} \;`;

            //Run the analysis with the workflow
            $cmd = '/usr/bin/snakemake -s ' . SYSTEM_DATA_ROOT . '/workflows/ChIP-seq_workflow_SE.py -j 8 --configfile ' . $pathToProject . '/metadata/ChIP/config.yml 2>' . $pathToProject . '/ChIP_stdout.txt';
            shell_exec($cmd);
            //echo $cmd;
        }
    }


    public function execute_rna_workflow_custom_parameters()
    {
        //print_r($_POST);
        if (!empty($_POST)) {//check if this array is empty.
            //step 1 rewrite config.yml
            $pathToProject = SYSTEM_PROJECTS_ROOT . "/" . $_POST['project_id'];
            $filenameYaml = SYSTEM_PROJECTS_ROOT . "/" . $_POST['project_id'] . "/metadata/RNA" . "/config.yml";
            unset($_POST['project_id']);
            $configinit = yaml_parse_file($filenameYaml);

            //step 1.1 store in an array tools choose before
            $tools_selected = array();
            //$configinit["tools"];

            foreach ($configinit["tools"] as $key => $value1){
                //$value1 == tool list separated by one blank space
                foreach (explode(" ", $value1) as $tool){
                    array_push($tools_selected,$tool);
                }

            }
            //print_r($tools_selected);

            //step 1.2 compare this array with key in the form

            foreach ($_POST as $key => $value1){
                if (in_array($key,$tools_selected)){
                    if (is_array($value1)){
                        //print_r($key."  ".$value1);
                        foreach ($value1 as $key2 => $value2) {
                            //print_r($key2."  ".$value2);
                            if (!empty($value2)){
                                $configinit[$key][$key2]=$value2;
                            }
                        }
                    }
                }
            }

            //Write the config file
            $res = yaml_emit_file($filenameYaml, $configinit);

            //step 2 run the analysis with the workflow

            //we need to touch all the data files before to run the analysis
            $pathToSamples = $pathToProject . "/samples";
            `find "{$pathToSamples}" -exec touch {} \;`;

            $cmd = '/usr/bin/snakemake -s ' . SYSTEM_DATA_ROOT . '/workflows/RNA-seq_workflow_SE.py -j 8 --configfile ' . $pathToProject . '/metadata/RNA/config.yml 2>' . $pathToProject . '/boum.txt';
            shell_exec($cmd);
            echo $cmd;

        }

    }


    public function execute_chip_workflow_custom_parameters()
    {
        //print_r($_POST);
        if (!empty($_POST)) {//check if this array is empty.
            //step 1 rewrite config.yml
            $pathToProject = SYSTEM_PROJECTS_ROOT . "/" . $_POST['project_id'];
            $filenameYaml = SYSTEM_PROJECTS_ROOT . "/" . $_POST['project_id'] . "/metadata/ChIP" . "/config.yml";
            unset($_POST['project_id']);
            $configinit = yaml_parse_file($filenameYaml);

            //step 1.1 store in an array tools choose before
            $tools_selected = array();
            //$configinit["tools"];

            foreach ($configinit["tools"] as $key => $value1){
                //$value1 == tool list separated by one blank space
                foreach (explode(" ", $value1) as $tool){
                    array_push($tools_selected,$tool);
                }

            }
            //print_r($tools_selected);

            //step 1.2 compare this array with key in the form

            foreach ($_POST as $key => $value1){
                if (in_array($key,$tools_selected)){
                    if (is_array($value1)){
                        //print_r($key."  ".$value1);
                        foreach ($value1 as $key2 => $value2) {
                            //print_r($key2."  ".$value2);
                            if (!empty($value2)){
                                $configinit[$key][$key2]=$value2;
                            }
                        }
                    }
                }
            }

            //Write the config file
            $res = yaml_emit_file($filenameYaml, $configinit);

            //step 2 run the analysis with the workflow

            //we need to touch all the data files before to run the analysis
            $pathToSamples = $pathToProject . "/samples";
            `find "{$pathToSamples}" -exec touch {} \;`;

            $cmd = '/usr/bin/snakemake -s ' . SYSTEM_DATA_ROOT . '/workflows/ChIP-seq_workflow_SE.py -j 8 --configfile ' . $pathToProject . '/metadata/ChIP/config.yml 2>' . $pathToProject . '/ChIP_stdout.txt';
            shell_exec($cmd);
            echo $cmd;

        }

    }


    public function go()
    {

		if ( !is_numeric($_GET['id']) || $_GET['id'] < 1 ) {

			$message['text'] = 'The requested project does not exist.';
			$message['type'] = 'alert';

			$this->session->message = $message;
			header("Location: /users/projects_users/");
			exit;

		}

		$this->project = $this->get_project($_GET['id']);

		if ( !$this->project->id || $this->project->id != $_GET['id'] ) {

			$message['text'] = 'The requested project does not exist (errno)';
			$message['type'] = 'alert';

			$this->session->message = $message;
			header("Location: /users/projects_users/");
			exit;

		}

		$this->set("project", $this->project);

	    if ( is_numeric($_GET['id']) && $_GET['id'] > 0 ) {
	   	 //get information on project from DB
            //print_r($this->project_info( (int)$_GET['id'] ));
	   	 	$this->set('project', $this->project_info( (int)$_GET['id'] ) );
            $this->all_files = $this->get_all_files_in_project($_GET['id']);
            $this->set('filetable', $this->all_files);
            $this->all_samples = $this->get_all_samples_in_project($_GET['id']);
            $this->set('sampletable', $this->all_samples);

			//which files in the project haven't yet been assigned to a sample?
			$unassigned_files = array();
			$assigned_files = array();
			foreach ($this->all_files as $file_obj) {
				$file_id = $file_obj->file_id;
				if ( $this->db_array_search($file_id, "file_1_id", $this->all_samples) ) { //file is assigned as "file1" in the samples array
					$assigned_files[] = $file_obj;
				} else if ( $this->db_array_search($file_id, "file_2_id", $this->all_samples) ) { //file is assigned as "file2" in the samples array
					$assigned_files[] = $file_obj;
				} else { // file is unassigned
					$unassigned_files[] = $file_obj;
				}
			}

			$this->set("unassigned_files", $unassigned_files); //this is used in the "unassigned files" column in the "Sequenced sample files" tab
			$this->set("assigned_files", $assigned_files); //this is used as a blank placeholder in the "unassigned files" column in the "Sequenced sample files" tab. We can drag assigned files to this to unassign them


			// what is the maximum number of samples we can have? == number of samples already assigned + number of unassigned files
			$this->set("max_num_samples", ( count($unassigned_files) + count($this->all_samples) ) );

            //separate sequence files into single-end or paired-end reads

            $this->all_rna_groups = $this->get_all_rna_groups_in_project($_GET['id']);
            $this->set('rna_groups', $this->all_rna_groups);

            $this->all_chip_groups = $this->get_all_chip_groups_in_project($_GET['id']);
            $this->set('chip_groups', $this->all_chip_groups);
            $this->set('chip_type', array("treated","input"));

            //Before to load this YAML file we need to check if it exist
            $filename = SYSTEM_PROJECTS_ROOT . "/" . $_GET['id'] . "/metadata/" . "/description.yml";
            $this->data_type_used = array();

            if (file_exists($filename)){
                $this->all_annotations = json_encode(yaml_parse_file($filename));

                $all_annotations = yaml_parse_file($filename);

                foreach ($all_annotations["Samples_information"]["Data_type"] as $data_type){
                    array_push($this->data_type_used, $data_type);
                }
            }else{
                $this->all_annotations = array();
            }
            $this->set('all_annotations', $this->all_annotations);
            $this->data_type_used = array_unique($this->data_type_used);
            $this->set('data_type_used', $this->data_type_used);

            $pathFolderMetada = SYSTEM_PROJECTS_ROOT . "/" . $_GET['id'] . "/metadata" ;

            if (in_array("ChIP-seq",$this->data_type_used) ) {
                if (!file_exists($pathFolderMetada . "/ChIP/")){
                    $pathFolderMetadaChIP = $pathFolderMetada . "/ChIP/";
                    mkdir($pathFolderMetadaChIP, 0777);
                }
            }

            if (in_array("RNA-seq",$this->data_type_used) ) {
                if (!file_exists($pathFolderMetada . "/RNA/")){
                    $pathFolderMetadaChIP = $pathFolderMetada . "/RNA/";
                    mkdir($pathFolderMetadaChIP, 0777);
                }
            }

            if (!file_exists($pathFolderMetada . "/ChIP/config.yml")){
                if (in_array("ChIP-seq",$this->data_type_used)){
                    //We want to be free about the config file's structure. So we need to create one and this one will be modified.
                    $config = array(
                        "project_name" => $_GET['id']
                    );
                    //Write the config file /metadata/RNA
                    $res = yaml_emit_file($pathFolderMetada . "/ChIP/config.yml", $config, $encoding = YAML_UTF8_ENCODING );
                }
            }


            if (!file_exists($pathFolderMetada . "/RNA/config.yml")){
                if (in_array("RNA-seq",$this->data_type_used)){
                    //We want to be free about the config file's structure. So we need to create one and this one will be modified.
                    $config = array(
                        "project_name" => $_GET['id']
                    );
                    //Write the config file /metadata/RNA
                    $res = yaml_emit_file($pathFolderMetada . "/RNA/config.yml", $config, $encoding = YAML_UTF8_ENCODING );
                }
            }

            /*Part about if the config file exist we need to read it and fill the corresponding form*/
            //ChIP Data side
            if (file_exists($pathFolderMetada . "/ChIP/config.yml")){
                $configChIP = yaml_parse_file($pathFolderMetada . "/ChIP/config.yml");
                //print_r(array_keys($configChIP));
                if (in_array("tools",array_keys($configChIP)) && in_array("metadata",array_keys($configChIP)) && in_array("genome",array_keys($configChIP))){
                    //print_r("toto");
                    $this->set('config_chip', $configChIP);
                }

            }

            /*Test to change input on select option for the genome part on the custom config*/
            //print_r(scandir(SYSTEM_DATA_ROOT .  "/genomes"));

            function dirToArray($dir) {// find on

                $result = array();

                $cdir = scandir($dir);
                foreach ($cdir as $key => $value)
                {
                    if (!in_array($value,array(".","..")))
                    {
                        if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
                        {
                            $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
                        }
                        else
                        {
                            $result[] = $value;
                        }
                    }
                }

                return $result;
            }

            $all_genome = dirToArray(SYSTEM_DATA_ROOT .  "/genomes");
            $this->set('all_genome', $all_genome);


            /*$this->rna_group_already_assignated = $this->rna_group_already_assigned_in_db($_GET['id']);
            $this->set('rna_group_already_assignated', $this->rna_group_already_assignated);*/

            $all_data_types = $this->get_all_data_type();

            foreach ($all_data_types as $data_type) {
                //print_r($data_type->type_id);
                $this->group_already_assignated = $this->group_already_assigned_in_db($_GET['id'], $data_type->type_id);
               if ($data_type->type_id == 1){
                   $this->set('chip_group_already_assignated', $this->group_already_assignated);
               } elseif ($data_type->type_id == 2){
                   $this->set('rna_group_already_assignated', $this->group_already_assignated);
               } else { // maybe error message not sure to be discussed with Andy

               }
            }

            //If the user already define if a chip sample is "treated" or "input"
            //print_r($this->get_all_chip_sample_type_asso($_GET['id']));
            $this->all_chip_sample_type = $this->get_all_chip_sample_type_asso($_GET['id']);
            $this->set('all_chip_sample_type',  $this->all_chip_sample_type);

            //print_r($this->get_all_chip_sample_type_input($_GET['id']));
            $this->all_chip_sample_type_input = $this->get_all_chip_sample_type_input($_GET['id']);
            $this->set('all_chip_sample_type_input',  $this->all_chip_sample_type_input);

            $this->all_chip_sample_type_treated = $this->get_all_chip_sample_type_treated($_GET['id']);
            $this->set('all_chip_sample_type_treated',  $this->all_chip_sample_type_treated);


            //If the user already define chip pair (one treated with one input)
            $this->all_chip_pair_already_defined = $this->get_all_chip_pair_already_defined($_GET['id']);
            //print_r($this->all_chip_pair_already_defined);
            //we get an array like one line by pair (object)
            $index = 1;
            $chip_pair = array();
            foreach ($this->all_chip_pair_already_defined as $pair){
                //print_r($pair->input_file_id);
                //get_name_and_md5sum_by_file_id
                //print_r($this->get_name_and_md5sum_by_file_id($pair->input_file_id));
                $input_file_info = $this->get_name_and_md5sum_by_file_id($pair->input_file_id);
                $treated_file_info = $this->get_name_and_md5sum_by_file_id($pair->treated_file_id);
                $array_name = "coupling_samples".$index;
                $chip_pair[$array_name] = array();
                array_push($chip_pair[$array_name],$treated_file_info );
                array_push($chip_pair[$array_name],$input_file_info );
                array_push($chip_pair[$array_name], $pair->chip_pair_id);
                $index ++;
            }
            $this->set('all_chip_pair_already_defined', $chip_pair);

            //If an association between a chip sample pair and a group is already defined load it
            //print_r($this->chip_group_already_assigned_in_db($_GET['id']));
            $this->set('chip_group_already_assigned', $this->chip_group_already_assigned_in_db($_GET['id']));

            /*31/03/2017 This is the old version base on the group name
            If in this project a design.tab file exist load it
            //RNA part
            $filenameDesign = SYSTEM_PROJECTS_ROOT . "/" . $_GET['id'] . "/metadata/RNA" . "/design.tab";
            $design_rna = array();
            if (file_exists($filenameDesign)) {//check if file exist
                $handle = fopen($filenameDesign, "r");//open a flux
                while (($data = fgetcsv($handle,  0, "\t")) !== FALSE) {//read line by line
                    array_push($design_rna,$data);//store every lines in a table
                }
                array_shift($design_rna);
                //print_r($design_rna);
                $this->set("design_rna",$design_rna);
            }

            //ChIP part
            $filenameDesign = SYSTEM_PROJECTS_ROOT . "/" . $_GET['id'] . "/metadata/ChIP" . "/design.tab";
            $design_chip = array();
            if (file_exists($filenameDesign)) {//check if file exist
                $handle = fopen($filenameDesign, "r");//open a flux
                while (($data = fgetcsv($handle,  0, "\t")) !== FALSE) {//read line by line
                    array_push($design_chip,$data);//store every lines in a table
                }
                array_shift($design_chip);
                //print_r($design_rna);
                $this->set("design_chip",$design_chip);
            }*/

            //Need to write process based on group_id

            //If in this project a design.tab file exist load it
            //RNA part
            $filenameDesign = SYSTEM_PROJECTS_ROOT . "/" . $_GET['id'] . "/metadata/RNA" . "/design.tab";
            $design_rna = array();
            if (file_exists($filenameDesign)) {//check if file exist
                $handle = fopen($filenameDesign, "r");//open a flux
                while (($data = fgetcsv($handle, 0, "\t")) !== FALSE) {//read line by line
                    array_push($design_rna, $data);//store every lines in a table
                }
                array_shift($design_rna);
                //print_r($design_rna);
                $design_rna_final=array();
                $count = 1;
                foreach ($design_rna as $analysis){
                    $new_array = array();
                    foreach ($analysis as $group_id){
                        //print_r($group); OK
                        //Creation d'une procedure get_group_name_by_group_id
                        $group_name = $this->get_group_name_by_group_id($group_id);
                        if($group_name != NULL){
                            array_push($new_array,$group_name);
                        }
                    }
                    array_push($design_rna_final,$new_array);

                }

                $this->set("design_rna",$design_rna_final);
            }




            /*If in this project a samples.tab file exist load it*/
            $filenameSamples = SYSTEM_PROJECTS_ROOT . "/" . $_GET['id'] . "/metadata/" . "/RNA/samples.tab";
            $samples_rna = array();
            if (file_exists($filenameSamples)) {//check if file exist
                $handle = fopen($filenameSamples, "r");//open a flux
                while (($data = fgetcsv($handle,  0, "\t")) !== FALSE) {//read line by line
                    array_push($samples_rna,$data);//store every lines in a table
                }
                array_shift($samples_rna);
                //print_r($design_rna);
                $this->set("samples_rna",$samples_rna);
            }

            /*Part about load all tools's name available to make analysis*/
            $filenameToolsAvailable = SYSTEM_CONFIG_TOOLS_DIR . "tools_available.yml";
            //$configToolsAvailable = json_encode(yaml_parse_file($filenameToolsAvailable));
            $configToolsAvailable = yaml_parse_file($filenameToolsAvailable);
            //print_r($configToolsAvailable);
            $this->set("tools_available",$configToolsAvailable);

            //print_r($configToolsAvailable["RNA-seq"]);
            $customConfigToolsRna = array();

            foreach ($configToolsAvailable["RNA-seq"] as $key => $value) {
                //print_r($value); return Array
                if (is_array($value)){
                    foreach ($value as $key2 => $item) {
                        //print_r($item); return only tool's name
                        $configFileByTool = SYSTEM_CONFIG_TOOLS_DIR . $item . ".yml";
                        if (file_exists($configFileByTool)){ // check if file tool.yml exist
                            array_push($customConfigToolsRna,yaml_parse_file($configFileByTool));// read and store customizable options by tool
                        }
                    }
                }
            }

            $this->set("custom_config_tools_rna", $customConfigToolsRna);

            $customConfigToolsChip = array();

            foreach ($configToolsAvailable["ChIP-seq"] as $key => $value) {
                //print_r($value); return Array
                if (is_array($value)){
                    foreach ($value as $key2 => $item) {
                        //print_r($item); return only tool's name
                        $configFileByTool = SYSTEM_CONFIG_TOOLS_DIR . $item . ".yml";
                        if (file_exists($configFileByTool)){ // check if file tool.yml exist
                            array_push($customConfigToolsChip,yaml_parse_file($configFileByTool));// read and store customizable options by tool
                        }
                    }
                }
            }

            $this->set("custom_config_tools_chip", $customConfigToolsChip);

            //we need a global variable path_project NOT SURE 19/10/2016
            //$this->set('path_project', SYSTEM_PROJECTS_ROOT . "/" . $_GET['id']);


            }

		$this->set('data_types', $this->all_data_types() );

    }

    public function __destruct()
    {
        parent::__destruct();
    }

}

?>