# encording: utf-8

# ruby bmi.rb 身長 体重 で動く

# 変数にコマンドから取得した値を代入する
sintyou = ARGV[0].to_f
taizyu = ARGV[1].to_i

# 身長がcmだった場合、mになおす
if sintyou > 100
  sintyoum = sintyou / 100
else
  sintyoum = sintyou
end

# BMIの計算をして変数に入れる
bmi = ( taizyu / ( sintyoum * sintyoum ) ).round(2)

# BMIの数値に合った言葉を変数に入れる
if bmi < 18.5
  tekisei = "低体重"
elsif bmi >= 18.5 && bmi < 25
  tekisei = "普通体重"
else bmi >= 25
  tekisei = "肥満"
end

# 適正体重の計算
tekisei2 = ((sintyoum * sintyoum) * 22).round(2)

# 出力
puts "あなたのBMIは、#{bmi}です。"
puts "あなたは、#{tekisei}です。"
puts "あなたの適正体重は、#{tekisei2}kgです。"