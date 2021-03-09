<?php


namespace App\Controller;


use App\Entity\EvaluationTask;
use App\Entity\SegmentPair;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use \PhpOffice\PhpSpreadsheet\IOFactory;

class ImportTaskController extends AbstractController
{
    /**
     * @Route("/admin/upload-file", name="upload_file")
     */
    public function uploadFileAction(Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('file',  FileType::class, [
                'label' => 'Upload the file (Excel file)',
                'mapped' => false,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Submit',
            ])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $inputFileName = $form->get('file')->getData();

            $newFileName = "/tmp/" . uniqid("import");
            move_uploaded_file($inputFileName, $newFileName);

            return $this->render('admin/import/select_sheet.html.twig', [
                'file_name' => $newFileName,
                'sheets' => $this->getSheets($newFileName),
            ]);
        } else {
            return $this->render('admin/import/index.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    }

    /**
     * @Route("/admin/preview-file", name="preview_file")
     */
    public function previewFileAction(Request $request)
    {
        $inputFileName = $request->request->get('file_name');
        $sheet = $request->request->get('selected-sheet');

        return $this->render('admin/import/import.html.twig',
            $this->previewFile($inputFileName, $sheet)
        );
    }

    /**
     * @Route("/admin/do-import-file", name="do_import_file")
     */
    public function doTheActualImportAction(Request $request)
    {
        $inputFileName = $request->request->get('file_name');
        $sheet = $request->request->get('selected_sheet');
        $this->doTheActualImport($inputFileName, $sheet);

        return $this->redirectToRoute("front_page");

    }

    private function doTheActualImport(string $inputFileName, int $noSheet)
    {
        $manager = $this->getDoctrine()->getManager();
        $data = $this->previewFile($inputFileName, $noSheet);

        $task = new EvaluationTask();
        $task->setTitle($data['title']);
        $task->setDescription($data['desc']);
        $task->setSrcLang($data['src_lang']);
        $task->setTrgLang($data['trg_lang']);

        foreach ($data['pairs'] as $p) {
            $pair = new SegmentPair();
            $pair->setSource($p[0]);
            $pair->setTarget($p[1]);
            $pair->setTask($task);

            $manager->persist($pair);
        }

        $manager->persist($task);
        $manager->flush();

        $prev = null;
        foreach($task->getSegments() as $current) {
            if($prev) {
                $current->setPrev($prev->getId());
                $prev->setNext($current->getId());
                $manager->persist($current);
                $manager->persist($prev);
            }

            $prev = $current;
        }
        $manager->flush();


/*
            'file_name' => $inputFileName,
*/

    }

    private function previewFile(string $inputFileName, int $noSheet): array
    {
        $inputFileType = "Xlsx";

        $reader = IOFactory::createReader($inputFileType);
        $spreadsheet = IOFactory::load($inputFileName);
        $sheetData = $spreadsheet->getSheet($noSheet)->toArray(null, true, true, true);

        $source = "";
        $target = "";
        $pairs = [];
        $first = true;

        $source_lang = $sheetData["1"]["B"];
        $target_lang = $sheetData["2"]["B"];
        $title = $sheetData["3"]["B"];
        $desc = $sheetData["4"]["B"];
        foreach (array_slice($sheetData, 5) as $data) {
            $t_source = $data["A"];
            $t_target = $data["B"];

            if((strlen($t_source) > 0 ) && (strlen($t_target) > 0)) {
                if(!$first) $pairs[] = [$source, $target];
                $first = false;
                $source = $t_source;
                $target = $t_target;
            } else {
                $source = $source . " " . $t_source;
                $target = $target . " " . $t_target;
            }
        }
        $pairs[] = [$source, $target];

        return [
            'pairs' => $pairs,
            'src_lang' => $source_lang,
            'trg_lang' => $target_lang,
            'title' => $title,
            'desc' => $desc,
            'selected' => $spreadsheet->getSheetNames()[$noSheet],
            'no_selected' => $noSheet,
            'file_name' => $inputFileName,
        ];
    }

    private function getSheets($fileName): array
    {
        $inputFileType = "Xlsx";

        $reader = IOFactory::createReader($inputFileType);
        $spreadsheet = IOFactory::load($fileName);

        return $spreadsheet->getSheetNames();
    }


}