---
paths:
  - 'app/Jobs/**'
---

# Jobs

## Configure queued classes with attributes
Use Queueable and select an App\Enums\Queues case with #[Queue]. Declare positive attempts with #[Tries] and a non-empty positive retry sequence with #[Backoff([...])] appropriate to the workload.
