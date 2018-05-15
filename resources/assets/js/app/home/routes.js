import Index from './index/index'
import { route, metaForceSetupUser } from '@/helpers/routes'

export default [
  route('home', '/', Index, metaForceSetupUser('Home', false, false))
]
