<?php

namespace App\Models;
use PDO;
class Quotation {

    public function getQuotationList() {
        global $pdo;

        $stmt = $pdo->prepare("
            SELECT 
                com_quotation.id as quotation_id,
                gbl_entity_patient.name AS patient_name,
                gbl_entity_patient.last_name AS patient_last_name,
                gbl_entity_patient.identification AS patient_identification,
                adm_admission.patient_condition as patient_condition,
                gbl_entity_professional.name AS professional_name,
                gbl_entity_professional.last_name AS professional_last_name,
                sch_slot.init_time AS appointment_start_time,
                sch_slot.end_time AS  appointment_end_time,
                sch_event.init_date AS appointment_date,
                cnt_medical_order.id AS medical_order_id,
                adm_admission_flow.step_description as admision_flow_step_description,
                STRING_AGG(cnt_medical_order_medicament.medicament_name, ', ') AS medicaments
            FROM com_quotation
            JOIN com_quotation_line ON com_quotation.id = com_quotation_line.com_quotation_id
            JOIN cnt_medical_order_medicament_quotation ON com_quotation_line.id = cnt_medical_order_medicament_quotation.line_id
            JOIN cnt_medical_order_medicament ON cnt_medical_order_medicament_quotation.cnt_medical_order_medicament_id = cnt_medical_order_medicament.id
            JOIN cnt_medical_order ON cnt_medical_order_medicament.cnt_medical_order_id = cnt_medical_order.id
            JOIN adm_admission_flow ON cnt_medical_order.adm_admission_flow_id = adm_admission_flow.id
            JOIN adm_admission ON adm_admission_flow.adm_admission_id = adm_admission.id
            JOIN adm_admission_appointment ON adm_admission.id = adm_admission_appointment.adm_admission_id
            JOIN sch_workflow_slot_assigned ON adm_admission_appointment.flow_id = sch_workflow_slot_assigned.id  -- Ajusta aquí si tu columna tiene otro nombre
            JOIN sch_slot_assigned ON sch_workflow_slot_assigned.sch_slot_assigned_id = sch_slot_assigned.id
            JOIN sch_slot ON sch_slot_assigned.sch_slot_id = sch_slot.id
            JOIN sch_event ON sch_slot.sch_event_id = sch_event.id
            JOIN sch_calendar ON sch_event.sch_calendar_id = sch_calendar.id
            JOIN gbl_entity AS gbl_entity_patient ON sch_slot_assigned.gbl_entity_id = gbl_entity_patient.id
            JOIN gbl_entity AS gbl_entity_professional ON sch_calendar.gbl_entity_id  = gbl_entity_professional.id
            GROUP BY
                quotation_id, patient_condition,admision_flow_step_description,
                gbl_entity_patient.name, gbl_entity_patient.last_name, gbl_entity_patient.identification,
                gbl_entity_professional.name, gbl_entity_professional.last_name,
                sch_slot.init_time, sch_slot.end_time, sch_event.init_date, cnt_medical_order.id");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getQuotationData($id) {
        global $pdo;

        $stmt = $pdo->prepare("
            SELECT 
                com_quotation.id as quotation_id,
                gbl_patient.name AS patient_first_name,
                gbl_patient.last_name AS patient_last_name,
                gbl_patient.identification AS patient_identification,
                gbl_professional.name AS professional_first_name,
                gbl_professional.last_name AS professional_last_name,
                sch_slot.init_time AS appointment_start_time,
                sch_slot.end_time AS appointment_end_time,
                com_quotation.date::DATE AS quotation_date
            FROM com_quotation
            JOIN com_quotation_line ON com_quotation.id = com_quotation_line.com_quotation_id
            JOIN cnt_medical_order_medicament_quotation ON com_quotation_line.id = cnt_medical_order_medicament_quotation.line_id
            JOIN cnt_medical_order_medicament ON cnt_medical_order_medicament_quotation.cnt_medical_order_medicament_id = cnt_medical_order_medicament.id
            JOIN cnt_medical_order ON cnt_medical_order_medicament.cnt_medical_order_id = cnt_medical_order.id
            JOIN adm_admission_flow ON cnt_medical_order.adm_admission_flow_id = adm_admission_flow.id
            JOIN adm_admission ON adm_admission_flow.adm_admission_id = adm_admission.id
            JOIN adm_admission_appointment ON adm_admission.id = adm_admission_appointment.adm_admission_id
            JOIN sch_workflow_slot_assigned ON adm_admission_appointment.flow_id = sch_workflow_slot_assigned.id
            JOIN sch_slot_assigned ON sch_workflow_slot_assigned.sch_slot_assigned_id = sch_slot_assigned.id
            JOIN sch_slot ON sch_slot_assigned.sch_slot_id = sch_slot.id
            JOIN sch_event ON sch_slot.sch_event_id = sch_event.id
            JOIN sch_calendar ON sch_event.sch_calendar_id = sch_calendar.id
            JOIN gbl_entity AS gbl_patient ON sch_slot_assigned.gbl_entity_id = gbl_patient.id AND gbl_patient.entity_type = 'patient'
            JOIN gbl_entity AS gbl_professional ON sch_calendar.gbl_entity_id = gbl_professional.id AND gbl_professional.entity_type = 'professional'
            WHERE com_quotation.id = :id
        ");

        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
