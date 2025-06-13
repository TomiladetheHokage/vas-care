<?php
require_once __DIR__ . '/../../config/constants.php';
?>


<?php if (isset($appointments['error'])): ?>
    <p class="text-red-600"><?= htmlspecialchars($appointments['error']) ?></p>
<?php endif; ?>

<?php if (empty($appointments)): ?>
    <div class="text-center text-gray-500 text-lg">
        No Appointments found.
    </div>
<?php else: ?>


    <div class="bg-white rounded-lg shadow overflow-x-auto">

        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-3 font-medium">Requested Day</th>
                <th class="px-4 py-3 font-medium">Confirmed Day</th>
                <th class="px-4 py-3 font-medium">Confirmed Time Slot</th>
                <th class="px-4 py-3 font-medium">Ailment</th>
                <th class="px-4 py-3 font-medium">Assigned Doctor</th>
                <th class="px-4 py-3 font-medium">Assigned By</th>
                <th class="px-4 py-3 font-medium">Status</th>
                <th class="px-4 py-3 font-medium">Comments</th>
                <th class="px-4 py-3 font-medium">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($appointments as $appointment): ?>
                <?php
                if (!is_array($appointment)) continue;
                $status = strtolower($appointment['status']);
                [$colorClass, $iconClass] = match ($status) {
                    'confirmed' => ['text-green-600', 'fa-solid fa-circle-check'],
                    'pending' => ['text-yellow-600', 'fa-solid fa-hourglass-half'],
                    'cancelled' => ['text-red-600', 'fa-solid fa-circle-xmark'],
                    'denied' => ['text-gray-500', 'fa-solid fa-ban'],
                    default => ['text-black', 'fa-solid fa-question-circle'],
                };
                ?>
                <tr class="border-t">
                    <td class="px-4 py-3">
                        <?php if (!empty($appointment['requested_date'])): ?>
                            <?= date('F j, Y', strtotime($appointment['requested_date'])) ?>
                        <?php else: ?>
                            Not specified
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-3">
                        <?php if (empty($appointment['appointment_date'])): ?>
                            <?= "No date assigned"; ?>
                        <?php else: ?>
                            <?= date("F j, Y", strtotime($appointment['appointment_date'])); ?>
                        <?php endif; ?>
                        <span id="appointmentDate-<?= $appointment['appointment_id'] ?>" class="hidden"><?= htmlspecialchars($appointment['appointment_date']) ?></span>
                    </td>

                    <td class="px-4 py-3">
                        <?php if (!empty($appointment['slot_start']) && !empty($appointment['slot_end'])): ?>
                            <?= date("g:i A", strtotime($appointment['slot_start'])) ?> -
                            <?= date("g:i A", strtotime($appointment['slot_end'])) ?>
                        <?php else: ?>
                            No time assigned
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-3"><?= htmlspecialchars($appointment['ailment']) ?></td>
                    <td class="px-4 py-3">
                        <?php
                        if (!empty($appointment['doctor_first_name']) && !empty($appointment['doctor_last_name'])) {
                            echo 'Dr. ' . htmlspecialchars($appointment['doctor_first_name']) . ' ' . htmlspecialchars($appointment['doctor_last_name']);
                        }
                        else echo 'Not Assigned';

                        ?>
                    </td>

                    <td class="px-4 py-3">
                        <?php
                        if (!empty($appointment['nurse_first_name']) && !empty($appointment['nurse_last_name'])) {
                            echo 'Nurse. ' . htmlspecialchars($appointment['nurse_first_name']) . ' ' . htmlspecialchars($appointment['nurse_last_name']);
                        }
                        else echo 'Not Assigned';
                        ?>
                    </td>

                    <td class="px-4 py-3 font-semibold <?= $colorClass ?>">
                        <i class="<?= $iconClass ?> mr-1"></i>
                        <?= ucfirst($appointment['status']) ?>
                    </td>

                    <td class="px-4 py-3">
                        <?= htmlspecialchars(!empty($appointment['comments']) ? $appointment['comments'] : 'No comment') ?>
                    </td>


                    <td class="px-4 py-3 text-center">

                        <select class="border rounded px-2 py-1"
                                onchange="handleActionSelect(this)"
                                data-appointment-id="<?= $appointment['appointment_id'] ?>"
                                data-appointment-date="<?= htmlspecialchars($appointment['appointment_date']) ?>"
                                data-ailment="<?= htmlspecialchars($appointment['ailment']) ?>"
                                data-medical-history="<?= htmlspecialchars($appointment['medical_history']) ?>"
                                data-current-medication="<?= htmlspecialchars($appointment['current_medication']) ?>"
                                data-status="<?= htmlspecialchars($appointment['status']) ?>"
                        >
                            <option value="">Actions</option>
                            <option value="edit-<?= $appointment['appointment_id'] ?>">Edit</option>
                            <option value="cancel-<?= $appointment['appointment_id'] ?>">Cancel</option>
                        </select>
                        <form id="cancel-<?= $appointment['appointment_id'] ?>" action="<?= BASE_URL; ?>/index.php?action=updateStatus" method="POST" style="display: none;">
                            <input type="hidden" name="appointment_id" value="<?= $appointment['appointment_id'] ?>">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="p-4 text-sm text-gray-500">Showing <?= $statistics['total_appointments'] ?> of <?= $statistics['total_appointments'] ?> appointments</div>
    </div>
<?php endif; ?>

<!--                <pre>--><?php //print_r($appointment); ?><!--</pre>-->

