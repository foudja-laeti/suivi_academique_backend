output "namespace" {
  value = kubernetes_namespace.suivi.metadata[0].name
}

output "laravel_service" {
  value = kubernetes_service.laravel.metadata[0].name
}
