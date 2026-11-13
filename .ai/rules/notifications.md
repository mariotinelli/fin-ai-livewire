---
paths:
  - 'app/Notifications/**'
---

# Notifications

## Configure queued classes with attributes
Queue notifications with ShouldQueue and Queueable. Select an App\Enums\Queues case with #[Queue], declare positive attempts with #[Tries], and define a non-empty positive retry sequence with #[Backoff([...])] appropriate to the workload.
