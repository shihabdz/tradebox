<?php
namespace App\Modules\Setting\Controllers\Admin;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Language extends BaseController {

    private $table  = "language";
    private $phrase = "phrase";

    public function index() {
        $data['title']     = display("Language List");
        $data['languages'] = $this->languages();
        $data['content']   = $this->BASE_VIEW . '\language\main';
        return $this->template->admin_layout($data);

    }

    public function phrase() {
        /**
         * pagination starts
         */
        $page            = ($this->uri->getSegment(4)) ? $this->uri->getSegment(4) : 0;
        $page_number     = (!empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1);
        $data["phrases"] = $this->phrases(20, ($page_number - 1) * 20);
        $total           = $this->common_model->countRow('language');
        $data['pager']   = $this->pager->makeLinks($page_number, 20, $total);

        /**
         * pagination ends
         */
        $data['languages'] = $this->languages();
        $data['content']   = $this->BASE_VIEW . '\language\phrase';
        return $this->template->admin_layout($data);

    }

    public function languages() {

        if ($this->db->tableExists($this->table)) {

            $fields = $this->db->getFieldData($this->table);

            $i = 1;

            foreach ($fields as $field) {

                if ($i++ > 2) {
                    $result[$field->name] = ucfirst($field->name);
                }

            }

            if (!empty($result)) {
                return $result;
            }

        } else {
            return false;
        }

    }

    public function addLanguage() {
        $language = preg_replace('/[^a-zA-Z0-9_]/', '', $this->request->getVar('language'));
        $language = strtolower($language);

        if (!empty($language)) {

            if (!$this->db->fieldExists($language, $this->table)) {
                $this->dbforge->addColumn($this->table, [
                    $language => [
                        'type' => 'TEXT',
                    ],
                ]);
                $this->session->setFlashdata('message', 'Language added successfully');
                return redirect()->to(base_url('backend/language/language_list'));
            }

        } else {
            $this->session->setFlashdata('exception', 'Please try again');
        }

        return redirect()->to(base_url('backend/language/language_list'));
    }

    public function editPhrase($language = null) {

        $search = $this->request->getVar('search');
        $where  = [];

        if (isset($search)) {
            $search = trim($search);
            $where  = " $language LIKE '%$search%' OR phrase LIKE '%$search%'";
        }

        /**
         * pagination starts
         */
        $page            = ($this->uri->getSegment(4)) ? $this->uri->getSegment(4) : 0;
        $page_number     = (!empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1);
        $data["phrases"] = $this->phrases(20, ($page_number - 1) * 20, $where);

        $total         = $this->common_model->countRow('language', $where);
        $data['pager'] = $this->pager->makeLinks($page_number, 20, $total);

        /**
         * pagination ends
         */
        $data['language'] = $language;

        $data['content'] = $this->BASE_VIEW . '\language\phrase_edit';
        return $this->template->admin_layout($data);

    }

    /**
     * Export Language Phrase
     *
     * @param [string] $language
     * @return void
     */
    public function exportPhrase($language = null) {

        $all_language = $this->db->table('dbt_language')->get()->getResult();

        $file_name = $language . '.xlsx';

        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Phrase');
        $sheet->setCellValue('B1', 'Label');
        $count = 2;

        foreach ($all_language as $row) {
            $sheet->setCellValue('A' . $count, $row->phrase);
            $sheet->setCellValue('B' . $count, $row->$language);
            $count++;
        }

        $writer = new Xlsx($spreadsheet);

        $writer->save($file_name);
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename="' . basename($file_name) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length:' . filesize($file_name));
        flush();

        readfile($file_name);

        exit;
    }

    /**
     * Import Language Phrase
     *
     * @param [string] $language
     * @return view
     */
    public function importPhrase($language = null) {

        $input = $this->validate([
            'file' => 'uploaded[file]|max_size[file,2048]',
        ]);

        if (!$input) {
            $this->session->setFlashdata('exception', 'Please try again!');
            return redirect()->back()->withInput();
        } else {

            /**
             * File Validation
             */

            if ($file = $this->request->getFile('file')) {

                if ($file->isValid()) {
                    $this->db->transBegin();

                    try {
                        $arr_file  = explode('.', $_FILES['file']['name']);
                        $extension = array_slice($arr_file, -1);

                        if ('csv' == $extension) {
                            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                        } else {
                            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                        }

                        $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
                        $sheetData   = $spreadsheet->getActiveSheet()->toArray();

                        $all_update_data = [];

                        /**
                         * Check Import Input file
                         */

                        if (!empty($sheetData)) {

                            for ($i = 1; $i < count($sheetData); $i++) {
                                $phrase = $sheetData[$i][0];
                                $label  = $sheetData[$i][1];

                                $phraseKey = $this->common_model->where_row('dbt_language', ['phrase' => $phrase]);

                                if ($phraseKey) {
                                    $all_update_data[] = [
                                        'phrase'  => $phrase,
                                        $language => $label,
                                    ];

                                }

                            }

                        }

                        /**
                         * Update All Phrase
                         */

                        if ($all_update_data && count($all_update_data)) {
                            $this->db->table('dbt_language')->updateBatch($all_update_data, 'phrase');

                            $this->db->transCommit();
                            $this->session->setFlashdata('message', 'Phrase Key Update Successfully');
                        } else {
                            $this->db->transRollback();
                            $this->session->setFlashdata('exception', 'Database Error');
                        }

                    } catch (\Throwable $th) {
                        $this->session->setFlashdata('exception', 'Database Error');
                        $this->db->transRollback();
                    }

                } else {
                    $this->session->setFlashdata('exception', 'Database Error');
                }

            } else {
                $this->session->setFlashdata('exception', 'Database Error');
            }

        }

        return redirect()->back();

    }

    public function phrases($limit = null, $offset = null, $where = []) {

        if ($this->db->tableExists($this->table)) {

            if ($this->db->fieldExists($this->phrase, $this->table)) {
                $builder = $this->db->table('language');
                return $builder->orderBy($this->phrase, 'asc')
                    ->where($where)
                    ->limit($limit, $offset)
                    ->get()
                    ->getResult();
            }

        }

        return false;
    }

    public function addLebel() {

        $language = $this->request->getVar('language');
        $phrase   = $this->request->getVar('phrase');
        $lang     = $this->request->getVar('lang');

        if (!empty($language)) {

            if ($this->db->tableExists($this->table)) {

                if ($this->db->fieldExists($language, $this->table)) {

                    if (sizeof($phrase) > 0) {

                        for ($i = 0; $i < sizeof($phrase); $i++) {
                            $this->validation->setRule("$lang[$i]", display('lang[]'), 'permit_empty|alpha_numeric_punct');
                            $where = [
                                $this->phrase => $phrase[$i],
                            ];
                            $setdata = [
                                $language => $lang[$i],
                            ];
                            $this->common_model->update($this->table, $where, $setdata);
                        }

                    }

                    $this->session->setFlashdata('message', 'Label added successfully!');
                    return redirect()->to(base_url('backend/language/edit_phrase/' . $language));
                }

            }

        }

        $error = $this->validation->listErrors();

        if ($this->request->getMethod() == "post") {
            $this->session->setFlashdata('exception', $error);
        }

        return redirect()->to(base_url('backend/language/edit_phrase' . $language));
    }

    public function addPhrase() {

        $lang = $this->request->getVar('phrase');

        if (sizeof($lang) > 0) {

            if ($this->db->tableExists($this->table)) {

                if ($this->db->fieldExists($this->phrase, $this->table)) {

                    foreach ($lang as $value) {

                        $value = trim(preg_replace("/\s*(?:[^\w\s])+/", "", $value));
                        $value = str_replace(' ', '_', $value);

                        $value = strtolower($value);

                        if (!empty($value)) {
                            $num_rows = $this->common_model->countRow($this->table, [$this->phrase => $value]);

                            if ($num_rows == 0) {
                                $this->common_model->insert($this->table, [$this->phrase => $value]);
                                $this->session->setFlashdata('message', 'Phrase added successfully');
                            } else {
                                $this->session->setFlashdata('exception', 'Phrase already exists!');
                            }

                        }

                    }

                    return redirect()->to(base_url('backend/language/phrase_list'));
                }

            }

        }

        $this->session->setFlashdata('exception', 'Please try again');
        return redirect()->to(base_url('backend/language/phrase_list'));
    }

    /**
     * Edit Phrase Key Page
     *
     * @param [dbt_language] $id
     * @return view
     */
    public function editPhraseKey($id = null) {
        $data['phraseKey']    = $this->common_model->where_row('dbt_language', ['id' => $id]);
        $data['language_key'] = ($data['phraseKey']) ? array_slice(array_keys((array) $data['phraseKey']), 3) : [];
        $data['content']      = $this->BASE_VIEW . '\language\phrase_key_edit';
        return $this->template->admin_layout($data);
    }

    /**
     * Update Phrase Key Value
     *
     * @return view
     */
    public function updatePhraseKey() {
        $id = $this->request->getPost('id');

        $input = $this->validate([
            'id'     => 'required|integer',
            'phrase' => "required|string|is_unique[dbt_language.phrase,id, $id]",
        ]);

        if ($input) {
            $this->db->transBegin();

            try {
                $phraseKey = $this->common_model->where_row('dbt_language', ['id' => $id]);

                $id           = $this->request->getPost('id');
                $phrase       = $this->request->getPost('phrase');
                $phrase_value = $this->request->getPost('phrase_value');

                $data = [];
                /**
                 * If not a system Phrase
                 */

                if ($phraseKey->system_default == 0) {
                    $data = [
                        'phrase' => $this->request->getPost('phrase'),
                    ];
                }

                if (isset($phrase_value) && !empty($phrase_value)) {

                    foreach ($phrase_value as $key => $value) {
                        $key        = str_replace("'", '', $key);
                        $data[$key] = $value;
                    }

                }

                $check = $this->common_model->update('dbt_language', ['id' => $id], $data);

                if ($check) {
                    $this->db->transCommit();
                    $this->session->setFlashdata('message', 'Phrase Key Update Successfully');
                    return redirect()->to(base_url('backend/language/phrase_list'));
                } else {
                    $this->session->setFlashdata('exception', 'Database Error');
                    $this->db->transRollback();
                }

            } catch (\Throwable $th) {
                $this->session->setFlashdata('exception', 'Database Error');
                $this->db->transRollback();
            }

        } else {
            $this->session->setFlashdata('exception', 'Please try again!');
        }

        return redirect()->back()->withInput();
    }

}
