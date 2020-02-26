<?php


namespace App\Http\Controllers;


use App\Currency;
use App\ExchangeRate;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExchangeRateController
{
    public function index(Request $request)
    {
        $validator = validator($request->post(), [
            'monto' => 'required|numeric',
            'moneda_origen' => 'required|string|size:3',
            'moneda_destino' => 'required|string|size:3',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $data = $validator->validated();

        $monedaOrigen = Currency::find($data['moneda_origen']);

        if (!$monedaOrigen) {
            throw new BadRequestHttpException("", null, 1001);
        }

        $monedaDestino = Currency::find($data['moneda_destino']);

        if (!$monedaDestino) {
            throw new BadRequestHttpException("", null, 1002);
        }

        $exchangeRate = ExchangeRate::where([
            'currencyIdFrom' => $data['moneda_origen'],
            'currencyIdTo' => $data['moneda_destino'],
        ])->first();

        if (!$exchangeRate) {
            throw new NotFoundHttpException();
        }

        return [
            'monto' => $data['monto'],
            'monto_cambiado' => $data['monto'] * $exchangeRate->rate,
            'moneda_origen' => $data['moneda_origen'],
            'moneda_destino' => $data['moneda_destino'],
            'tipo_cambio' => $exchangeRate->rate,
        ];
    }


    public function update(Request $request)
    {
        $validator = validator($request->post(), [
            'currency_from' => 'required|string|size:3',
            'currency_to' => 'required|string|size:3',
            'rate' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $data = $validator->validated();

        /** @var ExchangeRate $exchangeRate */
        $exchangeRate = ExchangeRate::where([
            'currencyIdFrom' => $data['currency_from'],
            'currencyIdTo' => $data['currency_to'],
        ])->first();

        if (!$exchangeRate) {
            throw new BadRequestHttpException();
        }

        $exchangeRate->rate = $data['rate'];
        $exchangeRate->save();

        return [
          'rate_updated' => $exchangeRate->rate,
        ];
    }
}
