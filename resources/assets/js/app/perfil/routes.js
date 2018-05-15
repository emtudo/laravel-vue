import Me from './me'
import { route, meta } from '@/helpers/routes'

export default [
  route('perfil', '/perfil', Me, meta('Profile'))
]
