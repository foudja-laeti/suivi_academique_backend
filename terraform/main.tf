resource "kubernetes_namespace" "suivi" {
  metadata {
    name = var.namespace
    labels = {
      app = "suivi-academique"
    }
  }
}

resource "kubernetes_deployment" "laravel" {
  metadata {
    name      = "laravel-app"
    namespace = var.namespace
  }

  spec {
    replicas = var.replicas

    selector {
      match_labels = {
        app = "laravel-app"
      }
    }

    template {
      metadata {
        labels = {
          app = "laravel-app"
        }
      }

      spec {
        automount_service_account_token = false
        enable_service_links            = false

        init_container {
          name              = "init-storage"
          image             = var.app_image
          image_pull_policy = "Always"
          command = [
            "sh", "-c",
            "mkdir -p /var/www/storage/framework/views /var/www/storage/framework/cache /var/www/storage/framework/sessions /var/www/storage/logs && chmod -R 775 /var/www/storage"
          ]
          volume_mount {
            name       = "app-storage"
            mount_path = "/var/www/storage"
          }
        }

        container {
          name  = "laravel-app"
          image = var.app_image

          port {
            container_port = 9000
          }

          env_from {
            config_map_ref {
              name = "suivi-academique-config"
            }
          }

          env_from {
            secret_ref {
              name = "suivi-academique-secret"
            }
          }

          volume_mount {
            name       = "app-storage"
            mount_path = "/var/www/storage"
          }

          liveness_probe {
            tcp_socket {
              port = "9000"
            }
            initial_delay_seconds = 15
            period_seconds        = 10
            failure_threshold     = 3
          }

          readiness_probe {
            tcp_socket {
              port = "9000"
            }
            initial_delay_seconds = 10
            period_seconds        = 5
            failure_threshold     = 3
          }

          resources {
            requests = {
              cpu    = "100m"
              memory = "128Mi"
            }
            limits = {
              cpu    = "500m"
              memory = "256Mi"
            }
          }
        }

        volume {
          name = "app-storage"
          empty_dir {}
        }
      }
    }
  }
}

resource "kubernetes_service" "laravel" {
  metadata {
    name      = "laravel-app-service"
    namespace = var.namespace
  }

  spec {
    selector = {
      app = "laravel-app"
    }

    port {
      port        = 9000
      target_port = 9000
    }

    type = "ClusterIP"
  }
}
