<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement($this->dropView());

        DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement($this->dropView());
    }

    /*
     *
     *
     *  CREATE VIEW report AS
                 SELECT
                    users.id as user_id,
                    users.first_name,
                    users.last_name,
                    users.email,
                    ROUND(SUM(report.total_amount),2) AS total
              FROM (
                    SELECT P1.total_amount, A1.user_id FROM payment_approvals as A1, payments as P1
                    WHERE A1.payment_id = P1.id AND A1.payment_type = 'App\\\\Models\\\\Payment'
                    AND A1.user_id AND NOT EXISTS (SELECT A2.id, A2.status FROM payment_approvals AS A2 WHERE A2.status = 'DISAPPROVED' AND A2.payment_id = P1.id AND A2.payment_type = 'App\\\\Models\\\\Payment' )
                    UNION ALL
                    SELECT P3.amount as total_amount, A3.user_id FROM payment_approvals as A3, travel_payments as P3
                    WHERE A3.payment_id = P3.id AND A3.payment_type = 'App\\\\Models\\\\TravelPayment'
                    AND A3.user_id AND NOT EXISTS (SELECT A4.id, A4.status FROM payment_approvals AS A4 WHERE A4.status = 'DISAPPROVED' AND A4.payment_id = P3.id AND A4.payment_type = 'App\\\\Models\\\\TravelPayment' )
                    ) AS report, users
                WHERE users.type = 'APPROVER' AND report.user_id = users.id
                GROUP BY users.id
            SQL;
     *
     *
     *
     *
     * */


    /**
     * Create view that will create report for approvers.
     *
     * @return string
     */
    private function createView(): string
    {
        return <<<SQL
            CREATE VIEW report AS
                 SELECT
                    users.id as user_id,
                    users.first_name,
                    users.last_name,
                    users.email,
                    ROUND(SUM(report.total_amount),2) AS total
              FROM (
                    SELECT P1.total_amount, A1.user_id FROM payment_approvals as A1, payments as P1
                    WHERE A1.payment_id = P1.id AND A1.payment_type = 'App\\\\Models\\\\Payment' AND A1.deleted_at IS NULL AND P1.deleted_at IS NULL
                    AND A1.user_id AND NOT EXISTS (SELECT A2.id, A2.status FROM payment_approvals AS A2 WHERE A2.status = 'DISAPPROVED' AND A2.payment_id = P1.id AND A2.payment_type = 'App\\\\Models\\\\Payment' AND A2.deleted_at IS NULL )
                    UNION ALL
                    SELECT P3.amount as total_amount, A3.user_id FROM payment_approvals as A3, travel_payments as P3
                    WHERE A3.payment_id = P3.id AND A3.payment_type = 'App\\\\Models\\\\TravelPayment' AND A3.deleted_at IS NULL AND P3.deleted_at IS NULL
                    AND A3.user_id AND NOT EXISTS (SELECT A4.id, A4.status FROM payment_approvals AS A4 WHERE A4.status = 'DISAPPROVED' AND A4.payment_id = P3.id AND A4.payment_type = 'App\\\\Models\\\\TravelPayment' AND A4.deleted_at IS NULL )
                    ) AS report, users
                WHERE users.type = 'APPROVER' AND report.user_id = users.id AND users.deleted_at IS NULL
                GROUP BY users.id
            SQL;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    private function dropView(): string
    {
        return <<<SQL
            DROP VIEW IF EXISTS `report`;
            SQL;
    }
};
