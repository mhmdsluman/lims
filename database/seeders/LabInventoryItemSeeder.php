<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabInventoryItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lab_items = [
            /* Personal protective equipment (PPE) */
            ['name'=>'Nitrile Gloves - Small','category'=>'PPE','unit'=>'box (100)','qty'=>0,'notes'=>null],
            ['name'=>'Nitrile Gloves - Medium','category'=>'PPE','unit'=>'box (100)','qty'=>0,'notes'=>null],
            ['name'=>'Nitrile Gloves - Large','category'=>'PPE','unit'=>'box (100)','qty'=>0,'notes'=>null],
            ['name'=>'Latex Gloves - Medium','category'=>'PPE','unit'=>'box (100)','qty'=>0,'notes'=>'if used; allergy caution'],
            ['name'=>'Powder-free Exam Gloves - XS','category'=>'PPE','unit'=>'box (100)','qty'=>0,'notes'=>null],
            ['name'=>'Disposable Isolation Gowns','category'=>'PPE','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Surgical Masks - ASTM Level 2','category'=>'PPE','unit'=>'box (50)','qty'=>0,'notes'=>null],
            ['name'=>'N95 Respirators','category'=>'PPE','unit'=>'box (10)','qty'=>0,'notes'=>null],
            ['name'=>'Face Shields','category'=>'PPE','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Safety Goggles','category'=>'PPE','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Lab Coats (disposable)','category'=>'PPE','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Shoe Covers (disposable)','category'=>'PPE','unit'=>'box (100)','qty'=>0,'notes'=>null],
            ['name'=>'Hair Nets / Bouffant Caps','category'=>'PPE','unit'=>'box (100)','qty'=>0,'notes'=>null],

            /* Collection & sampling supplies */
            ['name'=>'Vacutainer Blood Collection Tubes - EDTA (lavender)','category'=>'Blood Collection','unit'=>'pack (100)','qty'=>0,'notes'=>'hematology'],
            ['name'=>'Vacutainer Tubes - Serum Separator (SST/Gold)','category'=>'Blood Collection','unit'=>'pack (100)','qty'=>0,'notes'=>'chemistry'],
            ['name'=>'Vacutainer Tubes - Lithium Heparin (green)','category'=>'Blood Collection','unit'=>'pack (100)','qty'=>0,'notes'=>'chemistry/plasma'],
            ['name'=>'Vacutainer Tubes - Sodium Citrate (blue)','category'=>'Blood Collection','unit'=>'pack (100)','qty'=>0,'notes'=>'coagulation'],
            ['name'=>'Vacutainer Tubes - Fluoride Oxalate (gray)','category'=>'Blood Collection','unit'=>'pack (100)','qty'=>0,'notes'=>'glucose'],
            ['name'=>'Microtainers / Capillary Tubes (blood spots)','category'=>'Blood Collection','unit'=>'pack (100)','qty'=>0,'notes'=>null],
            ['name'=>'Capillary Tubes (heparinized)','category'=>'Blood Collection','unit'=>'box (100)','qty'=>0,'notes'=>null],
            ['name'=>'Syringes 1 mL (sterile)','category'=>'Collection','unit'=>'box (100)','qty'=>0,'notes'=>null],
            ['name'=>'Syringes 3 mL (sterile)','category'=>'Collection','unit'=>'box (100)','qty'=>0,'notes'=>null],
            ['name'=>'Needles 21G','category'=>'Collection','unit'=>'box (100)','qty'=>0,'notes'=>null],
            ['name'=>'Needles 23G','category'=>'Collection','unit'=>'box (100)','qty'=>0,'notes'=>null],
            ['name'=>'Butterfly Needles (winged set) 21G','category'=>'Collection','unit'=>'box (50)','qty'=>0,'notes'=>null],
            ['name'=>'Tourniquets (disposable)','category'=>'Collection','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Alcohol Prep Pads','category'=>'Collection','unit'=>'box (200)','qty'=>0,'notes'=>null],
            ['name'=>'Povidone-iodine wipes','category'=>'Collection','unit'=>'box (100)','qty'=>0,'notes'=>null],
            ['name'=>'Gauze 4x4 sterile','category'=>'Collection','unit'=>'box (200)','qty'=>0,'notes'=>null],
            ['name'=>'Band-Aids / Adhesive Dressings','category'=>'Collection','unit'=>'box (100)','qty'=>0,'notes'=>null],
            ['name'=>'Biohazard Specimen Bags with absorbent pad','category'=>'Transport','unit'=>'pack (100)','qty'=>0,'notes'=>null],
            ['name'=>'Cryovials 1.8 mL (screw cap, cryogenic)','category'=>'Storage','unit'=>'box (500)','qty'=>0,'notes'=>null],
            ['name'=>'Cryovials 2.0 mL (screw cap)','category'=>'Storage','unit'=>'box (500)','qty'=>0,'notes'=>null],
            ['name'=>'Urine Specimen Containers (sterile, 60 mL)','category'=>'Collection','unit'=>'pack (100)','qty'=>0,'notes'=>null],
            ['name'=>'Urine Culture Swabs (Cary-Blair transport)','category'=>'Collection','unit'=>'pack (100)','qty'=>0,'notes'=>null],
            ['name'=>'Stool Collection Containers (wide-mouth)','category'=>'Collection','unit'=>'pack (100)','qty'=>0,'notes'=>null],
            ['name'=>'Fecal Occult Blood Test Cards (FIT tubes)','category'=>'Collection','unit'=>'pack (50)','qty'=>0,'notes'=>null],
            ['name'=>'Sputum Cups (sterile)','category'=>'Collection','unit'=>'pack (50)','qty'=>0,'notes'=>null],
            ['name'=>'Cervical Cytology Brushes / ThinPrep vials','category'=>'Collection','unit'=>'pack (50)','qty'=>0,'notes'=>null],
            ['name'=>'Blood Culture Bottles - Aerobic','category'=>'Microbiology','unit'=>'box (50 pairs)','qty'=>0,'notes'=>'typically sold in aerobic/anaerobic sets'],
            ['name'=>'Blood Culture Bottles - Anaerobic','category'=>'Microbiology','unit'=>'box (50 pairs)','qty'=>0,'notes'=>null],
            ['name'=>'Nasopharyngeal Swabs (flocked)','category'=>'Collection','unit'=>'pack (100)','qty'=>0,'notes'=>'PCR/viral testing'],
            ['name'=>'Throat Swabs (sterile polyester)','category'=>'Collection','unit'=>'pack (100)','qty'=>0,'notes'=>null],
            ['name'=>'Sterile Cotton Swabs','category'=>'Collection','unit'=>'pack (500)','qty'=>0,'notes'=>null],
            ['name'=>'Dacron Swabs (molecular)','category'=>'Collection','unit'=>'pack (100)','qty'=>0,'notes'=>'PCR-compatible'],
            ['name'=>'Saliva Collection Kits','category'=>'Collection','unit'=>'each','qty'=>0,'notes'=>'molecular / DNA kits'],
            ['name'=>'Specimen Transport Media (viral transport medium)','category'=>'Transport','unit'=>'pack (50)','qty'=>0,'notes'=>null],
            ['name'=>'Sputum Induction Containers','category'=>'Collection','unit'=>'pack (50)','qty'=>0,'notes'=>null],

            /* Tubes, plates, reservoirs, filtration */
            ['name'=>'Conical Centrifuge Tubes 15 mL (sterile)','category'=>'Plasticware','unit'=>'pack (500)','qty'=>0,'notes'=>null],
            ['name'=>'Conical Centrifuge Tubes 50 mL (sterile)','category'=>'Plasticware','unit'=>'pack (250)','qty'=>0,'notes'=>null],
            ['name'=>'Microcentrifuge Tubes 1.5 mL (DNase/RNase-free)','category'=>'Plasticware','unit'=>'pack (1000)','qty'=>0,'notes'=>null],
            ['name'=>'PCR Tubes (0.2 mL, thin-walled)','category'=>'Molecular','unit'=>'pack (1000)','qty'=>0,'notes'=>null],
            ['name'=>'PCR Tube Strips (8-strip)','category'=>'Molecular','unit'=>'pack (500 strips)','qty'=>0,'notes'=>null],
            ['name'=>'PCR Plate 96-well (0.2 mL)','category'=>'Molecular','unit'=>'pack (50)','qty'=>0,'notes'=>null],
            ['name'=>'qPCR Optical Plates (96-well)','category'=>'Molecular','unit'=>'pack (50)','qty'=>0,'notes'=>null],
            ['name'=>'Flat-bottom 96-well Plates (ELISA)','category'=>'Assay','unit'=>'pack (50)','qty'=>0,'notes'=>null],
            ['name'=>'U-bottom 96-well Plates','category'=>'Assay','unit'=>'pack (50)','qty'=>0,'notes'=>null],
            ['name'=>'Microplate Sealers (adhesive)','category'=>'Assay','unit'=>'pack (100)','qty'=>0,'notes'=>null],
            ['name'=>'Microplate Adhesive Films (PCR compatible)','category'=>'Molecular','unit'=>'pack (100)','qty'=>0,'notes'=>null],
            ['name'=>'Deep Well Plates (96-well, 2 mL)','category'=>'Assay','unit'=>'pack (20)','qty'=>0,'notes'=>null],
            ['name'=>'Cell Culture Plates (6-well)','category'=>'Cell Culture','unit'=>'pack (50)','qty'=>0,'notes'=>null],
            ['name'=>'Cell Culture Flasks T25','category'=>'Cell Culture','unit'=>'pack (25)','qty'=>0,'notes'=>null],
            ['name'=>'Cell Culture Flasks T75','category'=>'Cell Culture','unit'=>'pack (25)','qty'=>0,'notes'=>null],
            ['name'=>'Cryogenic Storage Boxes (racks)','category'=>'Storage','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Microtube Racks (1.5/2 mL)','category'=>'Storage','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'PCR Plate Racks','category'=>'Storage','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Petri Dishes (90 mm sterile)','category'=>'Microbiology','unit'=>'pack (100)','qty'=>0,'notes'=>null],
            ['name'=>'Disposable Serological Pipettes 1 mL','category'=>'Pipettes','unit'=>'pack (100)','qty'=>0,'notes'=>null],
            ['name'=>'Disposable Serological Pipettes 5 mL','category'=>'Pipettes','unit'=>'pack (100)','qty'=>0,'notes'=>null],
            ['name'=>'Disposable Serological Pipettes 10 mL','category'=>'Pipettes','unit'=>'pack (100)','qty'=>0,'notes'=>null],
            ['name'=>'Reservoirs for multichannel pipettes','category'=>'Pipettes','unit'=>'pack (50)','qty'=>0,'notes'=>null],
            ['name'=>'Bottle-top Dispensers (screw-top)','category'=>'Dispensing','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Filter Units (syringe filter, 0.22 µm)','category'=>'Filtration','unit'=>'pack (100)','qty'=>0,'notes'=>null],

            /* Pipette tips & pipettes */
            ['name'=>'P1000 Filter Tips (sterile, box 96 racks)','category'=>'Pipette Tips','unit'=>'box (960)','qty'=>0,'notes'=>null],
            ['name'=>'P200 Filter Tips (sterile)','category'=>'Pipette Tips','unit'=>'box (960)','qty'=>0,'notes'=>null],
            ['name'=>'P20 Filter Tips (sterile)','category'=>'Pipette Tips','unit'=>'box (960)','qty'=>0,'notes'=>null],
            ['name'=>'P10 Low-Retention Tips','category'=>'Pipette Tips','unit'=>'box (960)','qty'=>0,'notes'=>null],
            ['name'=>'Electronic Pipette Single-channel (P1000)','category'=>'Instruments','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Manual Pipette P200 (adjustable)','category'=>'Instruments','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Manual Pipette P20 (adjustable)','category'=>'Instruments','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Multichannel Pipette 8-channel (P50)','category'=>'Instruments','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Pipette Tip Waste Boxes (biohazard)','category'=>'Waste','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Pipette Calibration Service (voucher)','category'=>'Service','unit'=>'each','qty'=>0,'notes'=>null],

            /* Reagents & solutions - general chemistry */
            ['name'=>'Sodium Chloride (0.9% sterile saline)','category'=>'Reagents','unit'=>'bottle (500 mL)','qty'=>0,'notes'=>null],
            ['name'=>'Phosphate Buffered Saline (PBS) 1X','category'=>'Reagents','unit'=>'bottle (1 L)','qty'=>0,'notes'=>null],
            ['name'=>'Distilled Water (for lab use)','category'=>'Reagents','unit'=>'bottle (5 L)','qty'=>0,'notes'=>null],
            ['name'=>'Deionized Water (DI)','category'=>'Reagents','unit'=>'bottle (20 L)','qty'=>0,'notes'=>null],
            ['name'=>'Tris Buffer (1 M)','category'=>'Reagents','unit'=>'bottle (500 mL)','qty'=>0,'notes'=>null],
            ['name'=>'EDTA Solution (0.5 M)','category'=>'Reagents','unit'=>'bottle (250 mL)','qty'=>0,'notes'=>null],
            ['name'=>'Phenol Red Solution','category'=>'Reagents','unit'=>'bottle (100 mL)','qty'=>0,'notes'=>null],
            ['name'=>'Sodium Hydroxide (NaOH) pellets','category'=>'Reagents','unit'=>'kg','qty'=>0,'notes'=>'chemical handling precautions'],
            ['name'=>'Hydrochloric Acid (HCl) 37%','category'=>'Reagents','unit'=>'bottle (1 L)','qty'=>0,'notes'=>'corrosive; store in acid cabinet'],
            ['name'=>'Acetic Acid (glacial)','category'=>'Reagents','unit'=>'bottle (1 L)','qty'=>0,'notes'=>'corrosive'],
            ['name'=>'Ethanol 70% (for disinfection)','category'=>'Reagents','unit'=>'bottle (5 L)','qty'=>0,'notes'=>null],
            ['name'=>'Isopropyl Alcohol 70%','category'=>'Reagents','unit'=>'bottle (5 L)','qty'=>0,'notes'=>null],
            ['name'=>'Methanol (HPLC grade)','category'=>'Solvents','unit'=>'bottle (1 L)','qty'=>0,'notes'=>'flammable'],
            ['name'=>'Acetonitrile (HPLC grade)','category'=>'Solvents','unit'=>'bottle (1 L)','qty'=>0,'notes'=>'flammable'],
            ['name'=>'Formaldehyde 37% (neutral buffered formalin)','category'=>'Fixatives','unit'=>'bottle (4 L)','qty'=>0,'notes'=>'fixation for histology'],
            ['name'=>'Paraformaldehyde powder','category'=>'Fixatives','unit'=>'kg','qty'=>0,'notes'=>'prepare fresh solutions'],
            ['name'=>'Glutaraldehyde 25%','category'=>'Fixatives','unit'=>'bottle (1 L)','qty'=>0,'notes'=>'EM fixation'],
            ['name'=>'Hydrogen Peroxide 3%','category'=>'Reagents','unit'=>'bottle (1 L)','qty'=>0,'notes'=>null],
            ['name'=>'Sodium Hypochlorite (Bleach) 5%','category'=>'Reagents','unit'=>'bottle (5 L)','qty'=>0,'notes'=>'disinfection'],
            ['name'=>'Neutral Buffered Formalin 10%','category'=>'Fixatives','unit'=>'bottle (10 L)','qty'=>0,'notes'=>null],

            /* Reagents - clinical chemistry assays (kits / controls) */
            ['name'=>'Glucose Reagent (hexokinase or glucose oxidase reagent)','category'=>'Assay Reagents','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'Urea/BUN Reagent Kit','category'=>'Assay Reagents','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'Creatinine Reagent Kit (Jaffe or enzymatic)','category'=>'Assay Reagents','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'Total Protein Reagent Kit','category'=>'Assay Reagents','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'Albumin Reagent Kit','category'=>'Assay Reagents','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'Bilirubin Reagent Kit (total & direct)','category'=>'Assay Reagents','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'ALT (GPT) Reagent Kit','category'=>'Assay Reagents','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'AST (GOT) Reagent Kit','category'=>'Assay Reagents','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'Alkaline Phosphatase Reagent','category'=>'Assay Reagents','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'GGT Reagent Kit','category'=>'Assay Reagents','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'Cholesterol Reagent Kit','category'=>'Assay Reagents','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'Triglycerides Reagent Kit','category'=>'Assay Reagents','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'HDL Cholesterol Reagent Kit','category'=>'Assay Reagents','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'LDL Calculation Reagent / Calibrator','category'=>'Calibrators','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Electrolyte Standards (Na/K/Cl)','category'=>'Standards','unit'=>'set','qty'=>0,'notes'=>null],
            ['name'=>'Calcium Reagent Kit','category'=>'Assay Reagents','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'Phosphate Reagent Kit','category'=>'Assay Reagents','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'Magnesium Reagent Kit','category'=>'Assay Reagents','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'Lipase Reagent Kit','category'=>'Assay Reagents','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'Amylase Reagent Kit','category'=>'Assay Reagents','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'Creatine Kinase (CK) Reagent','category'=>'Assay Reagents','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'Troponin I/T Calibrators','category'=>'Calibrators','unit'=>'set','qty'=>0,'notes'=>null],
            ['name'=>'BNP/NT-proBNP Reagent Kit','category'=>'Assay Reagents','unit'=>'kit','qty'=>0,'notes'=>null],

            /* Controls & calibrators */
            ['name'=>'Chemistry Level 1 Control','category'=>'Controls','unit'=>'bottle','qty'=>0,'notes'=>null],
            ['name'=>'Chemistry Level 2 Control','category'=>'Controls','unit'=>'bottle','qty'=>0,'notes'=>null],
            ['name'=>'Hematology Control (CBC) Level 1','category'=>'Controls','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'Hematology Control Level 2','category'=>'Controls','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'Coagulation Control Set','category'=>'Controls','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'Immunoassay Calibrators (multi-point)','category'=>'Calibrators','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'Molecular Positive Control (extraction/amplicon)','category'=>'Controls','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Molecular Negative Control (NTC)','category'=>'Controls','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'qPCR Standard Curve Mix (dilutions)','category'=>'Standards','unit'=>'set','qty'=>0,'notes'=>null],
            ['name'=>'Microbiology QC Strains (ATCC reference)','category'=>'Controls','unit'=>'each','qty'=>0,'notes'=>'store frozen or lyophilized'],

            /* Microbiology media & supplements */
            ['name'=>'Blood Agar Base (powder)','category'=>'Media','unit'=>'kg','qty'=>0,'notes'=>null],
            ['name'=>'Blood Agar Plates (pre-poured)','category'=>'Media','unit'=>'pack (50)','qty'=>0,'notes'=>null],
            ['name'=>'MacConkey Agar (pre-poured)','category'=>'Media','unit'=>'pack (50)','qty'=>0,'notes'=>null],
            ['name'=>'Chocolate Agar (pre-poured)','category'=>'Media','unit'=>'pack (50)','qty'=>0,'notes'=>null],
            ['name'=>'CLED Agar Plates (urine culture)','category'=>'Media','unit'=>'pack (50)','qty'=>0,'notes'=>null],
            ['name'=>'Sabouraud Dextrose Agar (fungal)','category'=>'Media','unit'=>'pack (50)','qty'=>0,'notes'=>null],
            ['name'=>'Thioglycollate Broth (liquid culture)','category'=>'Media','unit'=>'bottle (500 mL)','qty'=>0,'notes'=>null],
            ['name'=>'Brain Heart Infusion (BHI) Broth','category'=>'Media','unit'=>'bottle (500 mL)','qty'=>0,'notes'=>null],
            ['name'=>'Cary-Blair Transport Medium (swabs)','category'=>'Transport','unit'=>'pack (50)','qty'=>0,'notes'=>null],
            ['name'=>'Chocolate Agar Supplement (heated blood)','category'=>'Media Supplement','unit'=>'vial','qty'=>0,'notes'=>null],
            ['name'=>'Antibiotic Discs (Kirby-Bauer set)','category'=>'Microbiology','unit'=>'box (1 set)','qty'=>0,'notes'=>null],
            ['name'=>'Mueller-Hinton Agar (plates)','category'=>'Media','unit'=>'pack (50)','qty'=>0,'notes'=>null],
            ['name'=>'API Test Strips (biochemical identification)','category'=>'Microbiology Kits','unit'=>'box','qty'=>0,'notes'=>null],
            ['name'=>'Vitek ID Cards (automated ID)','category'=>'Microbiology Kits','unit'=>'pack','qty'=>0,'notes'=>null],
            ['name'=>'Selective media (Salmonella-Shigella)','category'=>'Media','unit'=>'pack (50)','qty'=>0,'notes'=>null],
            ['name'=>'Candida Chromogenic Agar','category'=>'Media','unit'=>'pack (50)','qty'=>0,'notes'=>null],

            /* Histology & cytology consumables */
            ['name'=>'Microtome Blades (disposable)','category'=>'Histology','unit'=>'box (50)','qty'=>0,'notes'=>null],
            ['name'=>'Paraffin Wax Blocks (paraffin)','category'=>'Histology','unit'=>'box (10)','qty'=>0,'notes'=>null],
            ['name'=>'Tissue Cassettes (with lids)','category'=>'Histology','unit'=>'box (500)','qty'=>0,'notes'=>null],
            ['name'=>'Cytology Fixative Spray / Preservative','category'=>'Cytology','unit'=>'bottle','qty'=>0,'notes'=>null],
            ['name'=>'Glass Microscope Slides (pre-cleaned)','category'=>'Microscopy','unit'=>'box (720)','qty'=>0,'notes'=>null],
            ['name'=>'Cover Slips (22x22 mm)','category'=>'Microscopy','unit'=>'box (1000)','qty'=>0,'notes'=>null],
            ['name'=>'Hematoxylin Stain (bottle)','category'=>'Stains','unit'=>'bottle (1 L)','qty'=>0,'notes'=>null],
            ['name'=>'Eosin Stain (bottle)','category'=>'Stains','unit'=>'bottle (1 L)','qty'=>0,'notes'=>null],
            ['name'=>'Periodic Acid–Schiff (PAS) reagent kit','category'=>'Stains','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'Immunohistochemistry Antibody Kits (various)','category'=>'IHC','unit'=>'each','qty'=>0,'notes'=>'e.g., cytokeratin, CD markers'],
            ['name'=>'DAB Chromogen Kit (IHC)','category'=>'IHC','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'Mounting Medium (permanent)','category'=>'Microscopy','unit'=>'bottle','qty'=>0,'notes'=>null],
            ['name'=>'Xylene (histology grade)','category'=>'Solvents','unit'=>'bottle (5 L)','qty'=>0,'notes'=>'flammable/toxic'],
            ['name'=>'Ethanol Series (70%, 95%, 100%)','category'=>'Reagents','unit'=>'bottle (5 L)','qty'=>0,'notes'=>null],
            ['name'=>'Coverslip Adhesive / Mountant','category'=>'Microscopy','unit'=>'bottle','qty'=>0,'notes'=>null],
            ['name'=>'Tissue Embedding Cassettes (plastic)','category'=>'Histology','unit'=>'box (500)','qty'=>0,'notes'=>null],
            ['name'=>'Tissue Processor Reagents (buffered formalin, alcohols, clearing agents)','category'=>'Histology','unit'=>'various','qty'=>0,'notes'=>null],

            /* Serology & immunology kits */
            ['name'=>'ELISA Kit - HIV Antibody','category'=>'Immunology','unit'=>'kit (96 wells)','qty'=>0,'notes'=>null],
            ['name'=>'ELISA Kit - Hepatitis B Surface Antigen','category'=>'Immunology','unit'=>'kit (96 wells)','qty'=>0,'notes'=>null],
            ['name'=>'ELISA Wash Buffer (concentrate)','category'=>'Immunology','unit'=>'bottle','qty'=>0,'notes'=>null],
            ['name'=>'ELISA Substrate (TMB)','category'=>'Immunology','unit'=>'bottle','qty'=>0,'notes'=>null],
            ['name'=>'ELISA Stop Solution (1M H2SO4)','category'=>'Immunology','unit'=>'bottle','qty'=>0,'notes'=>'acidic'],
            ['name'=>'Immunochromatographic Rapid Test Cassettes (various)','category'=>'POC Kits','unit'=>'box (25)','qty'=>0,'notes'=>null],
            ['name'=>'Latex Agglutination Reagents (CRP, ASO etc.)','category'=>'Immunology','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'Complement Fixation Reagents','category'=>'Immunology','unit'=>'kit','qty'=>0,'notes'=>null],

            /* Molecular biology reagents & consumables */
            ['name'=>'Nuclease-free Water (molecular grade)','category'=>'Molecular','unit'=>'bottle (500 mL)','qty'=>0,'notes'=>null],
            ['name'=>'RNase AWAY surface decontaminant','category'=>'Molecular','unit'=>'bottle','qty'=>0,'notes'=>null],
            ['name'=>'DNA Extraction Kit (spin-column)','category'=>'Molecular Kits','unit'=>'kit (50 preps)','qty'=>0,'notes'=>null],
            ['name'=>'RNA Extraction Kit (column or magnetic)','category'=>'Molecular Kits','unit'=>'kit (50 preps)','qty'=>0,'notes'=>null],
            ['name'=>'cDNA Reverse Transcriptase Kit','category'=>'Molecular Reagents','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'Taq DNA Polymerase (Standard)','category'=>'Molecular Reagents','unit'=>'tube','qty'=>0,'notes'=>null],
            ['name'=>'Hot-start Taq Polymerase','category'=>'Molecular Reagents','unit'=>'tube','qty'=>0,'notes'=>null],
            ['name'=>'dNTP Mix (10 mM each)','category'=>'Molecular Reagents','unit'=>'tube','qty'=>0,'notes'=>null],
            ['name'=>'PCR Master Mix (2X)','category'=>'Molecular Reagents','unit'=>'tube','qty'=>0,'notes'=>null],
            ['name'=>'SYBR Green qPCR Master Mix','category'=>'Molecular Reagents','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'Probe-based qPCR Mix (TaqMan)','category'=>'Molecular Reagents','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'Nuclease-free DNase I','category'=>'Molecular Reagents','unit'=>'tube','qty'=>0,'notes'=>null],
            ['name'=>'RNase Inhibitor','category'=>'Molecular Reagents','unit'=>'tube','qty'=>0,'notes'=>null],
            ['name'=>'Agarose LE grade (for electrophoresis)','category'=>'Molecular','unit'=>'kg','qty'=>0,'notes'=>null],
            ['name'=>'Ethidium Bromide solution (historical) or SYBR Safe','category'=>'Molecular','unit'=>'bottle','qty'=>0,'notes'=>'use safe alternatives where possible'],

            /* ELISA & immunoassay consumables */
            ['name'=>'ELISA Wash Bottles (squirt)','category'=>'Assay','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Microplate Reader Calibration Plates','category'=>'Instruments','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'ELISA Positive Control','category'=>'Controls','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'ELISA Negative Control','category'=>'Controls','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Coated ELISA Microplates (specific antigen/antibody)','category'=>'Assay','unit'=>'kit','qty'=>0,'notes'=>null],

            /* Coagulation & hemostasis supplies */
            ['name'=>'Citrated Plasma Tubes (3.2% Sodium Citrate)','category'=>'Blood Collection','unit'=>'pack (100)','qty'=>0,'notes'=>null],
            ['name'=>'Coagulation Control Material (PT/aPTT)','category'=>'Controls','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'Calcium Chloride (for clotting assays)','category'=>'Reagents','unit'=>'bottle','qty'=>0,'notes'=>null],
            ['name'=>'Thrombin Reagent (for fibrinogen assays)','category'=>'Reagents','unit'=>'vial','qty'=>0,'notes'=>null],
            ['name'=>'Chromogenic Substrate Kits (specific factors)','category'=>'Reagents','unit'=>'kit','qty'=>0,'notes'=>null],

            /* Hematology consumables */
            ['name'=>'Slide Staining Racks (hematology)','category'=>'Hematology','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Romanowsky Stain Set (Wright-Giemsa)','category'=>'Hematology','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'Hematology Controls (blood-based) Level 1/2','category'=>'Controls','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'Capillary Blood Collection Kits (lancets)','category'=>'Collection','unit'=>'box (100)','qty'=>0,'notes'=>null],
            ['name'=>'Lancets (automatic, single-use)','category'=>'Collection','unit'=>'box (100)','qty'=>0,'notes'=>null],
            ['name'=>'Hemoglobin A1c test cartridges (POC)','category'=>'POC Kits','unit'=>'box','qty'=>0,'notes'=>null],

            /* Instrument consumables & maintenance */
            ['name'=>'Analyzer Sample Cups / Cups (chemistry)','category'=>'Instruments','unit'=>'pack (500)','qty'=>0,'notes'=>null],
            ['name'=>'Autosampler Vials (2 mL, amber)','category'=>'Instruments','unit'=>'pack (100)','qty'=>0,'notes'=>null],
            ['name'=>'Autosampler Vial Caps and Septa','category'=>'Instruments','unit'=>'pack (100)','qty'=>0,'notes'=>null],
            ['name'=>'LC Column (analytical)','category'=>'Instruments','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'GC Column (capillary)','category'=>'Instruments','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'pH Meter Electrodes (replacement)','category'=>'Instruments','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Cuvettes (plastic disposable)','category'=>'Spectrophotometry','unit'=>'pack (500)','qty'=>0,'notes'=>null],
            ['name'=>'Spectrophotometer Lamp (deuterium/halogen)','category'=>'Instruments','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Water Purification System Filters (RO/DI)','category'=>'Instruments','unit'=>'set','qty'=>0,'notes'=>null],
            ['name'=>'Cryogenic Storage Labels (printed)','category'=>'Labels','unit'=>'roll','qty'=>0,'notes'=>null],
            ['name'=>'Barcode Printer Ribbons (wax/resin)','category'=>'Labels','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Laboratory Refrigerator/Freezer Thermometer (calibrated)','category'=>'Equipment','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Ultra-low Freezer Alarm Batteries','category'=>'Maintenance','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'CO2 Incubator Filters','category'=>'Instruments','unit'=>'each','qty'=>0,'notes'=>null],

            /* Waste management & decontamination */
            ['name'=>'Sharps Disposal Containers (1 L, 5 L, 10 L)','category'=>'Waste','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Biohazard Waste Bags (red/orange)','category'=>'Waste','unit'=>'roll (50)','qty'=>0,'notes'=>null],
            ['name'=>'Chemical Waste Bottles (HDPE)','category'=>'Waste','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Autoclave Bags (steam pouches)','category'=>'Waste','unit'=>'pack (200)','qty'=>0,'notes'=>null],
            ['name'=>'Autoclave Tape (steam indicator)','category'=>'Waste','unit'=>'roll','qty'=>0,'notes'=>null],
            ['name'=>'Spill Kits (biohazard)','category'=>'Safety','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Surface Disinfectant Wipes (EPA-registered)','category'=>'Cleaning','unit'=>'canister (160 wipes)','qty'=>0,'notes'=>null],
            ['name'=>'Chlorine/Test Strips (for bleach concentration)','category'=>'Cleaning','unit'=>'pack','qty'=>0,'notes'=>null],

            /* Labels, stationery & storage */
            ['name'=>'Laboratory Labels (cryovial, vinyl, 12x36mm)','category'=>'Labels','unit'=>'roll (1000)','qty'=>0,'notes'=>null],
            ['name'=>'Permanent Marker Pens (fine tip, lab grade)','category'=>'Stationery','unit'=>'box (12)','qty'=>0,'notes'=>null],
            ['name'=>'Freezer Boxes (2 mL tube boxes)','category'=>'Storage','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Inventory Barcode Labels (blank)','category'=>'Labels','unit'=>'roll','qty'=>0,'notes'=>null],
            ['name'=>'Specimen Tracking Forms (paper)','category'=>'Paperwork','unit'=>'pack (500)','qty'=>0,'notes'=>null],
            ['name'=>'Cryogenic Vial Boxes (rack for -80)','category'=>'Storage','unit'=>'each','qty'=>0,'notes'=>null],

            /* Calibration & verification tools */
            ['name'=>'pH Buffer Tablets (pH 4.0, 7.0, 10.0)','category'=>'Calibration','unit'=>'pack','qty'=>0,'notes'=>null],
            ['name'=>'Conductivity Standards','category'=>'Calibration','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Volumetric Flasks (Class A, 50 mL)','category'=>'Glassware','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Pipette Calibration Weights (balance)','category'=>'Calibration','unit'=>'set','qty'=>0,'notes'=>null],
            ['name'=>'Analytical Balance Calibration Weights','category'=>'Calibration','unit'=>'set','qty'=>0,'notes'=>null],

            /* Glassware & general lab equipment consumables */
            ['name'=>'Graduated Cylinders (100 mL)','category'=>'Glassware','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Erlenmeyer Flasks (250 mL)','category'=>'Glassware','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Beakers (1000 mL)','category'=>'Glassware','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Volumetric Pipettes (10 mL)','category'=>'Glassware','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Glass Slides (positively charged)','category'=>'Microscopy','unit'=>'box (720)','qty'=>0,'notes'=>null],
            ['name'=>'Disposable Pasteur Pipettes (glass)','category'=>'Glassware','unit'=>'pack (200)','qty'=>0,'notes'=>null],
            ['name'=>'Filter Paper (Whatman No.1)','category'=>'Filtration','unit'=>'pack','qty'=>0,'notes'=>null],

            /* Specialized reagents & kits (endocrine, oncology, genetics) */
            ['name'=>'TSH Assay Kit (immunoassay)','category'=>'Assay Kits','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'Free T4 Assay Kit','category'=>'Assay Kits','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'HbA1c Reagent Cartridges (lab analyzer)','category'=>'Assay Kits','unit'=>'box','qty'=>0,'notes'=>null],
            ['name'=>'PSA Assay Kit (immunoassay)','category'=>'Assay Kits','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'AFP Assay Kit','category'=>'Assay Kits','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'BRCA Genetic Testing Kit (sample prep)','category'=>'Genetics','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'NGS Library Prep Kit','category'=>'Genomics','unit'=>'kit','qty'=>0,'notes'=>null],
            ['name'=>'Sequencing Flow Cells / Chips (NGS)','category'=>'Genomics','unit'=>'each','qty'=>0,'notes'=>null],

            /* Rapid test & point-of-care (POC) consumables */
            ['name'=>'Glucose Test Strips (POC glucometer)','category'=>'POC','unit'=>'box (50)','qty'=>0,'notes'=>null],
            ['name'=>'Urine Pregnancy Test Strips (POC)','category'=>'POC','unit'=>'box (25)','qty'=>0,'notes'=>null],
            ['name'=>'INR Test Strips (POC coagulometer)','category'=>'POC','unit'=>'box (25)','qty'=>0,'notes'=>null],
            ['name'=>'Rapid Influenza A/B Test Kits','category'=>'POC','unit'=>'box (25)','qty'=>0,'notes'=>null],
            ['name'=>'Rapid Streptococcus A Test Kits','category'=>'POC','unit'=>'box (25)','qty'=>0,'notes'=>null],

            /* QC consumables for microscopy and imaging */
            ['name'=>'Microscope Calibration Slide (stage micrometer)','category'=>'Microscopy','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Oil Immersion Oil','category'=>'Microscopy','unit'=>'bottle (100 mL)','qty'=>0,'notes'=>null],
            ['name'=>'Lens Tissue (for optics cleaning)','category'=>'Cleaning','unit'=>'box','qty'=>0,'notes'=>null],

            /* Misc smallwares & helpers */
            ['name'=>'Forceps, stainless steel (various sizes)','category'=>'Smallwares','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Scissors, dissecting','category'=>'Smallwares','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Label Protectors (cryogenic)','category'=>'Labels','unit'=>'pack (100)','qty'=>0,'notes'=>null],
            ['name'=>'Disposable Funnels (plastic)','category'=>'Smallwares','unit'=>'pack (100)','qty'=>0,'notes'=>null],
            ['name'=>'Thermal Paper Rolls (printer)','category'=>'Stationery','unit'=>'roll','qty'=>0,'notes'=>null],

            /* Documentation & compliance */
            ['name'=>'MSDS Sheets Binder (paper copies)','category'=>'Paperwork','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Quality Control Logs (pre-printed)','category'=>'Paperwork','unit'=>'pack (100)','qty'=>0,'notes'=>null],
            ['name'=>'Calibration Certificates (file copies)','category'=>'Paperwork','unit'=>'each','qty'=>0,'notes'=>null],

            /* Items for specimen transport & courier */
            ['name'=>'Cooler Boxes with Ice Packs (transport)','category'=>'Transport','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Cold Packs / Gel Packs','category'=>'Transport','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Insulated Shipping Containers (dry ice compatible)','category'=>'Transport','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Dry Ice (solid CO2) - block','category'=>'Transport','unit'=>'kg','qty'=>0,'notes'=>'handle with gloves; supplier delivery required'],

            /* Additional: common spare parts & accessories */
            ['name'=>'Centrifuge Rotor (15 mL tube)','category'=>'Spare Parts','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Microcentrifuge Rotor (1.5/2 mL) spare','category'=>'Spare Parts','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Vortex Mixer Replacement Pad','category'=>'Spare Parts','unit'=>'each','qty'=>0,'notes'=>null],
            ['name'=>'Hotplate Stirrer Replacement','category'=>'Spare Parts','unit'=>'each','qty'=>0,'notes'=>null],
        ];

        foreach ($lab_items as $item) {
            DB::table('lab_inventory_items')->insert([
                'name' => $item['name'],
                'description' => $item['category'] . ($item['notes'] ? ' (' . $item['notes'] . ')' : ''),
                'unit' => $item['unit'],
                'quantity' => $item['qty'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
