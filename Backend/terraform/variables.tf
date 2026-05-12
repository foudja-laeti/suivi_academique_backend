variable "namespace" {
  default = "suivi-academique"
}

variable "app_image" {
  default = "stevetetchoup/laravel-app:latest"
}

variable "replicas" {
  default = 2
}
