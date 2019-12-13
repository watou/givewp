import ChartJS from 'chart.js'
import { useEffect, createRef } from 'react'
import { createConfig, calcHeight } from './utils'

const Chart = (props) => {

    const canvas = createRef()
    const config = createConfig(props)
    const height = calcHeight(props)

    useEffect(() => {

        const ctx = canvas.current.getContext('2d')
        const chart = new ChartJS(ctx, config)

        return function cleanup() {
            chart.destroy()
        }
        
    }, [])

    return (
        <div>
            <canvas width={100} height={height}  ref={canvas}></canvas>
        </div>
    )
}
export default Chart