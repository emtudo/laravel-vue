import { groupAdmin, route, meta } from '@/helpers/routes'
import Index from './index/index'
import Form from './form/form'

export default [
  ...groupAdmin('/users', [
    route('index', '/', Index, meta('Lista de usuário')),
    route('create', '/create', Form, meta('Adicionar novo usuário')),
    route('edit', '/:id/edit', Form, meta('Editar usuário'))
  ])
]
